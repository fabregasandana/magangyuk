import {
    createIcons, Activity, ArrowDown, ArrowDownToLine, ArrowLeft, ArrowRight, ArrowUp,
    ArrowUpRight, Award, Bell, BookOpen, BookOpenCheck, BriefcaseBusiness, Building2,
    Calendar, CalendarCheck, CalendarDays, CalendarOff, CalendarRange, Camera, ChartColumn,
    ChartNoAxesCombined, Check, ChevronDown, ChevronLeft, ChevronRight, ChevronsUpDown, ChevronUp,
    CircleAlert, CircleCheck, CircleHelp, ClipboardCheck, Clock, Download, Eye, EyeOff,
    File, FileCheck, FileCheck2, FileDown, FileText, FileUp, Filter, Fingerprint, GraduationCap, History,
    House, Images, Info, LayoutDashboard, Link, ListChecks, LockKeyhole, LogIn, LogOut, NotebookPen,
    Mail, MapPin, Menu, MessageCircle, MessageSquare, Moon, MoreHorizontal, Move,
    PanelLeft, PanelLeftClose, PanelsTopLeft, Pencil, Phone, Plus, RadioTower, RefreshCw,
    Save, ScanFace, Search, Send, Settings, Settings2, Shield, ShieldCheck,
    Sparkles, Star, Sun, Target, Trash2, TrendingUp, Upload, User,
    UserCheck, UserPlus, UserRound, UserRoundCheck, Users, UsersRound, X,
    ArrowUpDown, BadgeCheck, Ban, ClipboardList, Clock3, CloudUpload,
    GripVertical, Image, KeyRound, Megaphone, Paperclip, Pin, School,
    SlidersHorizontal, SquarePen, TriangleAlert, Zap,
} from 'lucide';

// Explicit imports keep the application bundle limited to the icons it uses.
const icons = {
    Activity, ArrowDown, ArrowDownToLine, ArrowLeft, ArrowRight, ArrowUp,
    ArrowUpRight, Award, Bell, BookOpen, BookOpenCheck, BriefcaseBusiness, Building2,
    Calendar, CalendarCheck, CalendarDays, CalendarOff, CalendarRange, Camera, ChartColumn,
    ChartNoAxesCombined, Check, ChevronDown, ChevronLeft, ChevronRight, ChevronsUpDown, ChevronUp,
    CircleAlert, CircleCheck, CircleHelp, ClipboardCheck, Clock, Download, Eye, EyeOff,
    File, FileCheck, FileCheck2, FileDown, FileText, FileUp, Filter, Fingerprint, GraduationCap, History,
    House, Images, Info, LayoutDashboard, Link, ListChecks, LockKeyhole, LogIn, LogOut, NotebookPen,
    Mail, MapPin, Menu, MessageCircle, MessageSquare, Moon, MoreHorizontal, Move,
    PanelLeft, PanelLeftClose, PanelsTopLeft, Pencil, Phone, Plus, RadioTower, RefreshCw,
    Save, ScanFace, Search, Send, Settings, Settings2, Shield, ShieldCheck,
    Sparkles, Star, Sun, Target, Trash2, TrendingUp, Upload, User,
    UserCheck, UserPlus, UserRound, UserRoundCheck, Users, UsersRound, X,
    ArrowUpDown, BadgeCheck, Ban, ClipboardList, Clock3, CloudUpload,
    GripVertical, Image, KeyRound, Megaphone, Paperclip, Pin, School,
    SlidersHorizontal, SquarePen, TriangleAlert, Zap,
};

export function renderIcons() {
    createIcons({ icons, attrs: { 'aria-hidden': 'true', 'stroke-width': 1.75 } });
}
