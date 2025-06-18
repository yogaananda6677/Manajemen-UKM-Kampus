module.exports = {
  content: [
    "./**/*.{php,html,js}", // Semua file php, html, js di semua folder dan subfolder
  ],
  theme: {
    extend: {
      fontFamily: {
        // 'sans' adalah font default untuk sebagian besar teks.
        // Ganti 'Poppins' dan 'Inter' dengan nama font yang Anda pilih dari Google Fonts.
        sans: ["Poppins", "sans-serif"], // Mengatur Poppins sebagai font default sans-serif
        heading: ["Inter", "sans-serif"], // Anda bisa membuat custom font family untuk judul
      },
    },
  },
  plugins: [require("daisyui")],
  // ...
};
