export default {
  darkMode: 'class',
  content: ["./resources/**/*.blade.php","./resources/**/*.js","./resources/**/*.vue"],
  theme: {
    extend: {
      colors: {
        brand: {
          100:"#E6F6EC", 300:"#78D7A0", 400:"#41C477",
          500:"#1DAE5A", 600:"#148746", 700:"#0E7A3A"
        },
        accent:"#22C55E",
        ink:{ DEFAULT:"#0F172A", sub:"#475569" },
        surface:"#F8FAF9",
        line:"#E5E7EB",
        success:"#16A34A", warning:"#D97706", danger:"#DC2626", info:"#0284C7",
      },
      boxShadow:{
        soft:"0 2px 10px rgba(16,24,40,.06)",
        elevated:"0 10px 20px rgba(16,24,40,.08)"
      },
      borderRadius:{ xl2:"1rem" }
    },
  },
  plugins:[require("@tailwindcss/forms")],
}
