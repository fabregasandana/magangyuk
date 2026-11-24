const PALETTE = ['#0b5ed7', '#78acfa', '#4386e7', '#a9cafd', '#084eaf', '#60a5fa'];
const STATUS_COLORS = { success: '#10b981', warning: '#f59e0b', danger: '#ef4444' };
const FONT = '"Plus Jakarta Sans Variable", "Plus Jakarta Sans", sans-serif';
const EMPTY = 'Belum ada data untuk ditampilkan.';
const INVALID = 'Data grafik tidak valid.';
const numberFormat = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 });
const formatValue = (value) => value === null || value === undefined ? 'Belum ada data' : numberFormat.format(value);
const isNumber = (value) => typeof value === 'number' && Number.isFinite(value);
const isLabel = (value) => typeof value === 'string' || isNumber(value);
const escapeHtml = (value) => String(value).replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[char]);

function seriesColor(label, index) {
    if (/sangat baik|berhasil|selesai/i.test(label)) return STATUS_COLORS.success;
    if (/perlu perbaikan|alpha|gagal/i.test(label)) return STATUS_COLORS.danger;
    if (/cukup|izin|terlambat/i.test(label)) return STATUS_COLORS.warning;
    if (/kehadiran|rata-rata|^baik/i.test(label)) return PALETTE[1];
    return PALETTE[index % PALETTE.length];
}

function axisOptions(scale, values, names, colors) {
    const axis = {
        seriesName: names,
        opposite: scale.position === 'right',
        show: scale.display !== false,
        forceNiceScale: false,
        labels: { style: { colors: colors.muted, fontSize: '12px' }, formatter: formatValue },
        axisBorder: { show: false },
        axisTicks: { show: false },
        title: { text: scale.title?.display ? scale.title.text : undefined, style: { color: colors.muted } },
    };
    // Null bounds mean automatic; explicit zero is not an absent bound.
    if (isNumber(scale.min)) axis.min = scale.min;
    if (isNumber(scale.max)) axis.max = scale.max;
    if (scale.beginAtZero && values.length) {
        if (axis.min === undefined && values.every((value) => value >= 0)) axis.min = 0;
        if (axis.max === undefined && values.every((value) => value <= 0)) axis.max = 0;
    }
    return axis;
}

/** Pure Chart.js/participant payload adapter; importing this module needs no DOM or ApexCharts. */
export function adaptChartConfig(payload, appearance = {}) {
    const invalid = { status: 'invalid', message: INVALID, labels: [], datasets: [], options: null };
    if (!payload || typeof payload !== 'object' || Array.isArray(payload)) return invalid;
    const participant = Array.isArray(payload.data);
    const type = participant ? 'line' : payload.type;
    if (!['line', 'bar', 'doughnut', 'radar'].includes(type)) return invalid;
    let labels = participant ? payload.labels : payload.data?.labels;
    const source = participant
        ? [{ label: payload.label ?? 'Skor Kinerja', data: payload.data, fill: true, tension: 0.4 }]
        : payload.data?.datasets;
    if (!Array.isArray(labels) || !labels.every(isLabel) || !Array.isArray(source)) return invalid;
    if (source.some((dataset) => !dataset || !Array.isArray(dataset.data)
        || dataset.data.length !== labels.length
        || !dataset.data.every((value) => value === null || isNumber(value))
        || (dataset.label != null && !isLabel(dataset.label)))) return invalid;
    if (type === 'doughnut' && source.length > 1) return invalid;

    labels = labels.map(String);
    const datasets = source.map((dataset, index) => ({
        name: String(dataset.label ?? (type === 'doughnut' ? 'Jumlah' : `Seri ${index + 1}`)),
        data: [...dataset.data],
        axis: String(dataset.yAxisID ?? 'y'),
    }));
    // Admin's legacy empty-institution sentinel is not an actual participant.
    if (type === 'doughnut' && labels.length === 1 && labels[0] === 'Belum ada data'
        && datasets[0]?.data[0] === 1) {
        labels = [];
        datasets[0].data = [];
    }
    const values = datasets.flatMap((dataset) => dataset.data).filter(isNumber);
    if (type === 'doughnut' && values.some((value) => value < 0)) return invalid;
    const empty = !values.length || (type === 'doughnut' && values.every((value) => value === 0));
    const mode = appearance.theme ?? (payload.variant === 'light' ? 'light' : 'dark');
    const dark = mode !== 'light';
    const colors = {
        text: appearance.text || (dark ? '#f8fafc' : '#0f172a'),
        muted: appearance.muted || (dark ? '#94a3b8' : '#64748b'),
        border: appearance.border || (dark ? '#334155' : '#e2e8f0'),
        surface: appearance.surface || (dark ? '#1e293b' : '#ffffff'),
    };
    const mobile = appearance.mobile ?? false;
    const settings = payload.options ?? {};
    const scales = settings.scales ?? {};
    const donut = type === 'doughnut';
    // Apex's non-axis parser cannot accept null slices. Omit only those slices,
    // retaining their original values/positions in the accessible data table.
    const pointIndexes = labels.map((_, index) => index).filter((index) => !donut || datasets[0]?.data[index] !== null);
    const seriesTypes = source.map((dataset) => type === 'line' && dataset.fill ? 'area' : type);
    const series = donut ? pointIndexes.map((index) => datasets[0]?.data[index]) : datasets.map((dataset, index) => ({
        name: dataset.name,
        data: [...dataset.data],
        ...(type === 'line' ? { type: seriesTypes[index] } : {}),
    }));
    const axisIds = [...new Set(datasets.map((dataset) => dataset.axis))];
    const axes = axisIds.map((id) => {
        const members = datasets.filter((dataset) => dataset.axis === id);
        const scale = type === 'radar' ? (scales.r ?? {}) : (scales[id] ?? {});
        return axisOptions(scale, members.flatMap((dataset) => dataset.data).filter(isNumber), members.map((dataset) => dataset.name), colors);
    });
    if (axes.some((axis) => axis.min !== undefined && axis.max !== undefined && axis.min > axis.max)) return invalid;
    // Keep the old participant score window, but never clip a real zero/low score.
    if (participant && axes[0]) {
        if (axes[0].min === undefined) axes[0].min = values.reduce((min, value) => Math.min(min, value), 60);
        if (axes[0].max === undefined) axes[0].max = values.reduce((max, value) => Math.max(max, value), 100);
    }
    const options = {
        chart: {
            type: donut ? 'donut' : type,
            height: appearance.height ?? 260,
            width: '100%',
            fontFamily: FONT,
            foreColor: colors.text,
            background: 'transparent',
            parentHeightOffset: 0,
            toolbar: { show: false },
            zoom: { enabled: false },
            redrawOnParentResize: false,
            redrawOnWindowResize: false,
            animations: { enabled: !appearance.reducedMotion, speed: 350, animateGradually: { enabled: false }, dynamicAnimation: { enabled: !appearance.reducedMotion, speed: 300 } },
            stacked: type === 'bar' && Boolean(scales.y?.stacked || scales.x?.stacked),
        },
        theme: { mode: dark ? 'dark' : 'light' },
        series,
        colors: donut ? pointIndexes.map((index) => seriesColor(labels[index], index)) : datasets.map((dataset, index) => seriesColor(dataset.name, index)),
        dataLabels: { enabled: false },
        stroke: {
            width: donut || type === 'bar' ? 0 : 3,
            curve: source.map((dataset) => dataset.tension > 0 ? 'smooth' : 'straight'),
        },
        fill: { opacity: donut || type === 'bar' ? 0.9 : source.map((dataset) => dataset.fill || type === 'radar' ? 0.14 : 1) },
        markers: { size: mobile ? 3 : 4, showNullDataPoints: false, strokeColors: colors.surface, hover: { sizeOffset: 2 } },
        grid: { borderColor: colors.border, strokeDashArray: 4, xaxis: { lines: { show: false } } },
        legend: {
            show: settings.plugins?.legend?.display ?? !participant,
            position: settings.plugins?.legend?.position ?? 'bottom',
            fontSize: mobile ? '12px' : '13px',
            height: mobile ? 48 : undefined,
            labels: { colors: colors.muted },
            formatter: (name) => escapeHtml(mobile && String(name).length > 26 ? `${String(name).slice(0, 25)}…` : name),
            onItemClick: { toggleDataSeries: false },
            onItemHover: { highlightDataSeries: false },
        },
        tooltip: { theme: dark ? 'dark' : 'light', shared: !donut, intersect: false, style: { fontFamily: FONT, fontSize: '12px' } },
        noData: { text: EMPTY, style: { color: colors.muted, fontFamily: FONT } },
        plotOptions: {
            bar: { borderRadius: 5, columnWidth: mobile ? '60%' : '48%' },
            pie: { expandOnClick: false, donut: { size: /^\d+(\.\d+)?%$/.test(settings.cutout) ? settings.cutout : '62%' } },
            radar: { polygons: { strokeColors: colors.border, connectorColors: colors.border, fill: { colors: ['transparent'] } } },
        },
    };
    if (donut) {
        options.labels = pointIndexes.map((index) => labels[index]);
    } else {
        options.xaxis = {
            categories: [...labels],
            labels: {
                rotate: 0,
                hideOverlappingLabels: true,
                trim: true,
                style: { colors: colors.muted, fontSize: mobile ? '12px' : '13px' },
                formatter: (value) => String(value).replace(/^Minggu\s+/i, 'M').slice(0, mobile ? 16 : 24),
            },
            axisBorder: { show: false },
            axisTicks: { show: false },
            tooltip: { enabled: false },
        };
        if (isNumber(scales.x?.min)) options.xaxis.min = scales.x.min;
        if (isNumber(scales.x?.max)) options.xaxis.max = scales.x.max;
        options.yaxis = type === 'radar' ? axes[0] : axes;
    }
    // Apex closes radar polygons through missing values as zero. A table is
    // more honest than a fabricated vertex until every category has a value.
    const incompleteRadar = type === 'radar' && datasets.some((dataset) => dataset.data.includes(null));
    return {
        status: empty ? 'empty' : incompleteRadar ? 'summary' : 'ready',
        message: empty ? (values.length ? 'Semua nilai 0; belum ada distribusi untuk ditampilkan.' : EMPTY)
            : incompleteRadar ? 'Data radar belum lengkap. Lihat rincian data di bawah.' : '',
        type,
        labels,
        datasets,
        pointIndexes,
        options,
    };
}

const charts = new Map();
let apexPromise;
let observer;
let resizeObserver;
let motion;
let frame;
let lifecycleAttached = false;

function loadApexCharts() {
    // No chart elements means this function is never called and no chart chunk is downloaded.
    apexPromise ??= import('apexcharts').then((module) => module.default).catch((error) => {
        apexPromise = undefined;
        throw error;
    });
    return apexPromise;
}

function element(tag, text) {
    const node = document.createElement(tag);
    if (text !== undefined) node.textContent = text;
    return node;
}

function dataDetails(model, title) {
    const details = element('details');
    details.style.cssText = 'flex:0 0 auto;max-height:48%;overflow:auto;font-size:12px;color:var(--ui-muted,#94a3b8);border-top:1px solid var(--ui-border,#334155)';
    const summary = element('summary', 'Lihat data grafik');
    summary.style.cssText = 'cursor:pointer;padding:5px 0';
    details.append(summary);
    const table = element('table');
    table.style.cssText = 'width:100%;border-collapse:collapse;text-align:left;color:var(--ui-text,#f8fafc)';
    table.append(element('caption', title));
    const header = element('tr');
    ['Periode / kategori', ...model.datasets.map((dataset) => dataset.name)].forEach((name) => {
        const cell = element('th', name);
        cell.scope = 'col';
        header.append(cell);
    });
    const thead = element('thead');
    thead.append(header);
    table.append(thead);
    const tbody = element('tbody');
    model.labels.forEach((label, index) => {
        const row = element('tr');
        const heading = element('th', label);
        heading.scope = 'row';
        row.append(heading);
        model.datasets.forEach((dataset) => row.append(element('td', formatValue(dataset.data[index]))));
        tbody.append(row);
    });
    table.append(tbody);
    table.querySelectorAll('th,td').forEach((cell) => { cell.style.cssText = 'padding:6px;border-bottom:1px solid var(--ui-border,#334155);overflow-wrap:anywhere'; });
    details.append(table);
    return details;
}

function prepareChart(node) {
    let host = node;
    if (node.tagName === 'CANVAS') {
        host = element('div');
        Array.from(node.attributes).forEach((attribute) => host.setAttribute(attribute.name, attribute.value));
        node.replaceWith(host);
    }
    let payload;
    try { payload = JSON.parse(host.dataset.chart); } catch { payload = null; }
    const model = adaptChartConfig(payload);
    const title = host.getAttribute('aria-label') || host.closest('.glass-card')?.querySelector('h2,h3,h4')?.textContent.trim()
        || model.datasets.map((dataset) => dataset.name).join(', ') || 'Grafik';
    host.setAttribute('role', 'group');
    host.setAttribute('aria-label', title);
    Object.assign(host.style, { display: 'flex', flexDirection: 'column', width: '100%', minWidth: '0', minHeight: '180px', fontFamily: FONT });
    host.style.height ||= '100%';
    const plot = element('div');
    plot.style.cssText = 'flex:1 1 0;min-height:0;min-width:0;width:100%;position:relative';
    plot.setAttribute('role', 'img');
    plot.setAttribute('aria-label', `${title}. ${model.labels.length} kategori; ${model.datasets.length} seri. Nilai kosong berarti belum ada data. Rincian tersedia pada Lihat data grafik.`);
    host.replaceChildren(plot);
    if (model.labels.length) host.append(dataDetails(model, title));
    const state = { host, plot, payload, model, instance: null, busy: false, failed: false, signature: '', active: true, source: host.dataset.chart };
    charts.set(host, state);
    if (model.status !== 'ready') showMessage(state, model.message);
    else plot.replaceChildren(chartSkeleton());
    resizeObserver?.observe(plot);
    return state;
}

/** Shimmer placeholder while the ApexCharts chunk loads (PRD: skeleton loading). */
function chartSkeleton() {
    const wrap = element('div');
    wrap.className = 'chart-skeleton';
    wrap.setAttribute('aria-hidden', 'true');
    [70, 92, 58, 80, 44, 66].forEach((width, index) => {
        const line = element('span');
        line.style.height = index === 0 ? '9px' : '14px';
        line.style.width = `${width}%`;
        wrap.append(line);
    });
    return wrap;
}

function showMessage(state, message) {
    state.plot.removeAttribute('role');
    state.plot.setAttribute('role', 'status');
    state.plot.setAttribute('aria-label', message);
    const text = element('p', message);
    text.style.cssText = 'display:flex;align-items:center;justify-content:center;height:100%;padding:12px;text-align:center;font-size:13px;color:var(--ui-muted,#94a3b8)';
    state.plot.replaceChildren(text);
}

function tooltipFor(state) {
    // DOM nodes, not interpolated HTML: institution names and labels may be user-supplied.
    return ({ seriesIndex, dataPointIndex }) => {
        const model = state.model;
        const donut = model.type === 'doughnut';
        const index = donut ? model.pointIndexes[seriesIndex] : dataPointIndex;
        const tooltip = element('div');
        tooltip.style.cssText = 'padding:10px 12px;max-width:min(260px,75vw);white-space:normal;overflow-wrap:anywhere;border:1px solid var(--ui-border,#334155);border-radius:10px;background:var(--ui-surface,#1e293b);color:var(--ui-text,#f8fafc)';
        tooltip.append(element('strong', model.labels[index] ?? ''));
        model.datasets.forEach((dataset) => tooltip.append(element('div', `${dataset.name}: ${formatValue(dataset.data[index])}`)));
        return tooltip;
    };
}

function currentAppearance(state) {
    const styles = getComputedStyle(document.body);
    return {
        theme: document.documentElement.dataset.theme === 'light' ? 'light' : 'dark',
        text: styles.getPropertyValue('--ui-text').trim(),
        muted: styles.getPropertyValue('--ui-muted').trim(),
        border: styles.getPropertyValue('--ui-border').trim(),
        surface: styles.getPropertyValue('--ui-surface').trim(),
        reducedMotion: motion?.matches ?? false,
        mobile: state.plot.clientWidth < 480,
        height: Math.round(state.plot.clientHeight),
    };
}

function destroyState(state) {
    state.active = false;
    resizeObserver?.unobserve(state.plot);
    // A render in flight owns its instance until its promise settles.
    if (!state.busy) {
        state.instance?.destroy();
        state.instance = null;
        state.plot.replaceChildren();
    }
    charts.delete(state.host);
}

async function renderChart(state) {
    if (state.busy || state.failed || state.model.status !== 'ready' || !state.host.isConnected) return;
    if (state.plot.clientWidth < 1 || state.plot.clientHeight < 1 || !state.plot.getClientRects().length) {
        state.signature = ''; // A shown tab must recalculate even if it returns to the same size.
        return;
    }
    const appearance = currentAppearance(state);
    const signature = JSON.stringify([appearance, state.plot.clientWidth]);
    if (state.signature === signature) return;
    state.busy = true;
    try {
        const ApexCharts = await loadApexCharts();
        if (!state.active || !state.host.isConnected || !state.plot.clientWidth) return;
        state.model = adaptChartConfig(state.payload, appearance);
        const options = state.model.options;
        options.tooltip.custom = tooltipFor(state);
        if (state.instance) {
            await state.instance.updateOptions(options, false, false, false);
        } else {
            state.plot.replaceChildren();
            state.instance = new ApexCharts(state.plot, options);
            await state.instance.render();
        }
        state.signature = signature;
    } catch {
        state.instance?.destroy();
        state.instance = null;
        state.failed = true;
        if (state.active) showMessage(state, 'Grafik tidak dapat dimuat. Data tetap tersedia di bawah.');
    } finally {
        state.busy = false;
        if (!state.active) {
            state.instance?.destroy();
            state.instance = null;
            state.plot.replaceChildren();
        }
        scheduleCharts();
    }
}

function scheduleCharts() {
    if (frame || !charts.size) return;
    frame = requestAnimationFrame(() => {
        frame = undefined;
        charts.forEach((state) => {
            if (!state.host.isConnected) destroyState(state);
            else renderChart(state);
        });
    });
}

function watchCharts() {
    if (observer) return;
    motion = window.matchMedia?.('(prefers-reduced-motion: reduce)');
    motion?.addEventListener('change', scheduleCharts);
    window.addEventListener('theme:change', scheduleCharts, true);
    window.addEventListener('resize', scheduleCharts);
    resizeObserver = typeof ResizeObserver === 'undefined' ? undefined : new ResizeObserver(scheduleCharts);
    observer = new MutationObserver((records) => {
        let discover = false;
        let changed = false;
        records.forEach((record) => {
            if (record.type === 'childList') {
                [...record.addedNodes, ...record.removedNodes].forEach((node) => {
                    if (node.nodeType === 1 && (node.matches('[data-chart]') || node.querySelector('[data-chart]'))) discover = true;
                });
            } else {
                charts.forEach((state) => {
                    if (record.target === state.host && state.source !== state.host.dataset.chart) {
                        destroyState(state);
                        discover = true;
                    } else if (record.target.contains(state.host)) changed = true;
                });
                if (record.attributeName === 'data-chart') discover = true;
            }
        });
        if (discover) {
            charts.forEach((state) => { if (!state.host.isConnected) destroyState(state); });
            initCharts();
        }
        if (changed) scheduleCharts();
    });
    observer.observe(document.documentElement, { childList: true, subtree: true, attributes: true, attributeFilter: ['class', 'style', 'hidden', 'data-theme', 'data-chart'] });
}

/** Idempotent; hidden tab charts wait for a real layout before loading/rendering. */
export function initCharts(root = document) {
    const nodes = [...(root.matches?.('[data-chart]') ? [root] : []), ...root.querySelectorAll('[data-chart]')];
    if (!nodes.length) return;
    watchCharts();
    if (!lifecycleAttached) {
        window.addEventListener('pagehide', destroyCharts);
        window.addEventListener('pageshow', restoreCharts);
        lifecycleAttached = true;
    }
    nodes.forEach((node) => { if (!charts.has(node)) prepareChart(node); });
    scheduleCharts();
}

export function destroyCharts() {
    observer?.disconnect();
    observer = undefined;
    resizeObserver?.disconnect();
    resizeObserver = undefined;
    motion?.removeEventListener('change', scheduleCharts);
    window.removeEventListener('theme:change', scheduleCharts, true);
    window.removeEventListener('resize', scheduleCharts);
    if (frame) cancelAnimationFrame(frame);
    frame = undefined;
    charts.forEach(destroyState);
}

function restoreCharts(event) {
    if (event.persisted) initCharts();
}

if (import.meta.hot) {
    import.meta.hot.dispose(() => {
        destroyCharts();
        window.removeEventListener('pagehide', destroyCharts);
        window.removeEventListener('pageshow', restoreCharts);
    });
}
