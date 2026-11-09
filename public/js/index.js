tailwind.config = {
    theme: {
        extend: {
            colors: {
                "komdigi-blue": "#0055FF",
                "komdigi-dark": "#00336C",
                "komdigi-cerulean": "#0093DD",
                "komdigi-gold": "#FFB700",
                "komdigi-red": "#C41E3A",
                "komdigi-light": "#E8F1FF",
                "komdigi-soft": "#E0EDFF",
                "komdigi-mid": "#C5DBFF",
            },
            fontFamily: {
                sans: ["Inter", "sans-serif"],
            },
            animation: {
                float: "float 6s ease-in-out infinite",
                "float-slow": "float 8s ease-in-out infinite",
                "pulse-soft": "pulse-soft 3s ease-in-out infinite",
                gradient: "gradient 8s ease infinite",
                shine: "shine 3s ease-in-out infinite",
            },
            keyframes: {
                float: {
                    "0%, 100%": { transform: "translateY(0px)" },
                    "50%": { transform: "translateY(-14px)" },
                },
                "pulse-soft": {
                    "0%, 100%": { opacity: "1" },
                    "50%": { opacity: "0.7" },
                },
                gradient: {
                    "0%, 100%": { backgroundPosition: "0% 50%" },
                    "50%": { backgroundPosition: "100% 50%" },
                },
                shine: {
                    "0%": { backgroundPosition: "-200% center" },
                    "100%": { backgroundPosition: "200% center" },
                },
            },
        },
    },
};