export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                mint: "#dff3ea",
                "mint-600": "#6fb69e",
                aqua: "#00cccc",
                "aqua-2": "#00aaaa",
                turmeric: "#ffb347",
                "turmeric-2": "#ffaa00",
                butter: "#ffe7a3",
                blush: "#f6d1c7",
                sky: "#d7e9fb",
                ink: "#1a1a1a",
                "ink-60": "#6b7280",
                paper: "#ffffff",
                "paper-2": "#faf8f6",
                yellowish: "#fff7d6",
                "yellowish-2": "#ffe6a6",
            },
            boxShadow: {
                soft: "0 10px 30px rgba(0,0,0,.06)",
            },
            borderRadius: {
                xl: "18px",
            },
            fontFamily: {
                sans: ["Lato", "sans-serif"],
                poppins: ["Poppins", "sans-serif"],
            },
        },
    },
    plugins: [
        function ({ addVariant }) {
            addVariant("x-cloak", ["&[x-cloak]"]);
        },
    ],
};
