export function updateTheme(theme) {
  const root = document.querySelector('html')
  if (theme === 'light') {
    root.classList.remove('dark')
  } else {
    root.classList.add('dark')
  }
}
