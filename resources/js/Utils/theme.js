export function updateTheme(theme) {
  const root = document.querySelector('html')
  if (theme === 'light') {
    root.classList.remove('dark')
    document.querySelector('meta[name="apple-mobile-web-app-status-bar-style"]').setAttribute('content', 'default')
  } else {
    root.classList.add('dark')
    document.querySelector('meta[name="apple-mobile-web-app-status-bar-style"]').setAttribute('content', 'black-translucent')
  }
}
