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
                                        butter: "#ffe7a3",
                                        blush: "#f6d1c7",
                                        sky: "#d7e9fb",
                                        ink: "#1a1a1a",
                                        "ink-60": "#6b7280",
                                        paper: "#ffffff",
                                        "paper-2": "#faf8f6",
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
          plugins: [],
};
