import { onMounted, onUnmounted, ref } from "vue"

export default function useMedia(query, defaultState = false) {
  let mql
  const matches = ref(defaultState)

  const updateMatchValue = () => (matches.value = mql.matches)

  onMounted(() => {
    mql = window.matchMedia(query)
    mql.addListener(updateMatchValue)
    updateMatchValue()
  })

  onUnmounted(() => {
    mql.removeListener(updateMatchValue)
  })

  return matches
}
