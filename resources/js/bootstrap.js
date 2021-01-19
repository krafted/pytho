import axios from 'axios'
import resolveConfig from 'tailwindcss/resolveConfig'
import tailwindConfig from '../../tailwind.config'
import { InertiaProgress } from '@inertiajs/progress'

const config = resolveConfig(tailwindConfig)

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

InertiaProgress.init({
  delay: 250,
  color: config.theme.colors.primary[500],
  includeCSS: true,
  showSpinner: false,
})
