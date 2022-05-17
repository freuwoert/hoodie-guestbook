require('./bootstrap')

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'

import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import 'dayjs/locale/de'

import MarketierUI from "marketier-ui";
import "marketier-ui/dist/style.css";

dayjs.locale('de')
dayjs.extend(relativeTime)

// const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - Morris' Hoodie Gästebuch`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const instance = createApp({ render: () => h(app, props) })
        instance.config.globalProperties.$date = dayjs
        instance.use(plugin)
        instance.use(MarketierUI)
        instance.mixin({ methods: { route } })
        instance.mount(el)
    },
})

InertiaProgress.init({ color: '#4B5563' })
