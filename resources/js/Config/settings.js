export const nonEditorSettings = ['layout', 'theme']

export default {
  fontSize: 16,
  indentUnit: 2,
  keyMap: 'default',
  layout: 'vertical',
  theme: window.matchMedia('(prefers-color-scheme: dark)').matches
    ? 'dark'
    : 'light',
  lineHeight: 2,
}
