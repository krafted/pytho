export const nonEditorPreferences = ['autoRun', 'layout', 'theme']

export default {
  autoRun: true,
  fontSize: 16,
  indentUnit: 2,
  keyMap: 'default',
  layout: 'vertical',
  theme: window.matchMedia('(prefers-color-scheme: dark)').matches
    ? 'dark'
    : 'light',
  lineHeight: 2,
}
