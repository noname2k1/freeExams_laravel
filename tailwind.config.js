/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            padding: {
                primary: "100px",
            },
            backgroundImage: {
                "it-pattern":
                    "linear-gradient(to right bottom, rgba(43, 108, 176, 0.9), rgba(43,200, 176, 0.9)), url('/public/assets/images/it_bg.png')",
                "language-pattern":
                    "linear-gradient(to right bottom, rgba(50, 200, 176, 0.9), rgba(43, 108, 176, 0.9)), url('/public/assets/images/language_bg.png')",
                "other-pattern":
                    "linear-gradient(to right bottom, rgba(50, 200, 100, 0.9), rgba(43, 108, 176, 0.9)), url('/public/assets/images/other_bg.png')",
            },
        },
    },
    plugins: [],
};
