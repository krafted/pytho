<template>
    <div
        v-show="show || isMd"
        id="searchContainer"
        ref="container"
        class="absolute z-10 w-full md:relative md:z-0"
    >
        <div class="flex items-center">
            <input
                v-model="query"
                ref="input"
                class="placeholder-gray-500 pl-4 pr-14 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-100 dark:border-gray-800 h-10.5 focus:bg-white dark:focus:bg-gray-900 w-full py-2.5 text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 focus:ring-offset-white dark:focus:ring-offset-gray-900 focus:border-gray-300 dark:focus:border-gray-600"
                placeholder="Search"
                type="text"
                @input="search"
                @focus="showResults = true"
            />

            <span
                v-if="!isMobile"
                class="inline-block text-gray-700 dark:text-gray-400 absolute right-2.5 py-0.5 px-1.5 border border-gray-200 dark:border-gray-700 rounded text-2xs"
            >
                {{ isMac ? '⌘K' : '⌃K' }}
            </span>
        </div>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div
                v-if="showResults && (results.allPens?.length || results.ownedPens?.length || results.users?.length)"
                class="absolute w-full mt-2 overflow-auto text-sm origin-top bg-white rounded-md shadow-lg search__results dark:bg-gray-900 max-h-64"
            >
                <div v-if="results.ownedPens?.length">
                    <div class="block px-4 py-2 font-semibold tracking-wide text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 text-2xs">
                        Owned
                    </div>
                    <div>
                        <inertia-link
                            v-for="(result, index) in results.ownedPens"
                            :key="index"
                            :href="route('pen.show', result.slug)"
                            class="block py-2.5 px-4 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:bg-gray-100 dark:focus:bg-gray-800"
                        >
                            <h5 class="font-medium" v-html="result.title" />
                            <p class="text-xs text-gray-600 dark:text-gray-400" v-html="result.description" />
                        </inertia-link>
                    </div>
                </div>
                <div v-if="results.allPens?.length">
                    <div class="block px-4 py-2 font-semibold tracking-wide text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 text-2xs">
                        All
                    </div>
                    <div>
                        <inertia-link
                            v-for="(result, index) in results.allPens"
                            :key="index"
                            :href="route('pen.show', result.slug)"
                            class="block py-2.5 px-4 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:bg-gray-100 dark:focus:bg-gray-800"
                        >
                            <h5 class="font-medium" v-html="result.title" />
                            <p class="text-xs text-gray-600 dark:text-gray-400" v-html="result.description" />
                        </inertia-link>
                    </div>
                </div>
                <div v-if="results.users?.length">
                    <div class="block px-4 py-2 font-semibold tracking-wide text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 text-2xs">
                        Users
                    </div>
                    <div>
                        <inertia-link
                            v-for="(result, index) in results.users"
                            :key="index"
                            :href="route('profile.show', result.slug)"
                            class="block py-2.5 px-4 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:bg-gray-100 dark:focus:bg-gray-800"
                        >
                            <h5 class="font-medium" v-html="result.name" />
                            <p class="text-xs text-gray-600 dark:text-gray-400" v-html="`@${result.username}`" />
                        </inertia-link>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import { inject, nextTick, onMounted, onUnmounted, ref, watchEffect } from 'vue'
    import axios from 'axios'
    import debounce from 'debounce'
    import hotkeys from 'hotkeys-js'

    export default {
        setup() {
            const isMac = inject('isMac')
            const isMobile = inject('isMobile')
            const isMd = inject('isMd')
            const container = ref(null)
            const input = ref(null)
            const query = ref('')
            const results = ref({})
            const show = inject('showSearch')
            const showResults = ref(false)
            const close = event => {
                if (event.target.closest('#searchButton')) return
                if (!event.target === container.value || !event.target.closest('#searchContainer')) {
                    showResults.value = false
                    show.value = false
                }
            }
            const search = debounce(async () => {
                if (!query.value) {
                    results.value = {}

                    return
                }

                axios
                    .get(`${route('search.index')}?search=${query.value}`)
                    .then(({ data }) => (console.log(data), results.value = data, showResults.value = true))
            }, 250)

            watchEffect(async () => {
                if (show.value) {
                    await nextTick()
                    input.value && input.value.focus()
                }
            })

            onMounted(() => {
                hotkeys(isMac.value ? 'cmd+k' : 'ctrl+k', async (event) => {
                    show.value = true
                    await nextTick()
                    input.value.focus()
                    event.preventDefault()
                })

                hotkeys('esc', (event) => {
                    showResults.value = false
                    event.preventDefault()
                })

                document.addEventListener('click', close)
            })
            onUnmounted(() => {
                hotkeys.unbind(isMac.value ? 'cmd+k' : 'ctrl+k')
                hotkeys.unbind('esc')
                document.removeEventListener('click', close)
            })

            return {
                container,
                input,
                isMac,
                isMd,
                isMobile,
                query,
                results,
                search,
                show,
                showResults,
            }
        },
    }
</script>
