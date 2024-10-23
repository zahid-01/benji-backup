/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            extend: {
                screens: {
                    "3xl": "1600px",
                },
            },
            colors: {
                textColor: "#0F0F0F",
                cta: "#42d477",
                gray: "#f1f1f1",
                blue: "#1f3a64",
                borderGray: "#cccccc",
                textGray: "#00000080",
                black80: "#000000CC",
                blue: "#1F3B64",
            },
        },
    },
    plugins: [require("daisyui"), require("@tailwindcss/line-clamp")],
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")[
                        "[data-theme=light]"
                    ],
                    "--btn-text-case": "none",
                    primary: "#42d477",
                    "primary-content": "#FFFFFF",
                    secondary: "#65a30d",
                },
            },
        ],
    },
};
