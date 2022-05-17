<template>
    <div class="comment">
        <p class="comment-content">{{data.content}}</p>
        <p class="comment-date">
            <span v-if="data.name">Geposted von <b>{{data.name}}</b></span>
            <span v-else>Anonym gepostet</span>
            {{$date(data.date).fromNow()}}
        </p>
        
        <div class="approve-bar" v-if="moderation">
            <mui-button class="flex-1" :variant="data.status === 'denied' ? 'filled' : 'contained'" size="small" color="error" label="Blockieren" @click="$emit('deny', data)"/>
            <mui-button class="flex-1" :variant="data.status === 'approved' ? 'filled' : 'contained'" size="small" color="success" label="Akzeptieren" @click="$emit('approve', data)"/>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                type: Object,
                required: true,
            },

            moderation: {
                type: Boolean,
                default: false,
            },
        },
    }
</script>

<style lang="sass" scoped>
    .comment
        position: relative
        background: var(--color-background-secondary)
        color: var(--color-heading)
        border-radius: .5rem
        box-shadow: var(--shadow-elevation-low)
        display: flex
        flex-direction: column

        .comment-content
            margin: 0
            word-break: break-word
            word-wrap: break-word
            font-size: 1rem
            padding: 1rem
            padding-bottom: .5rem

        .comment-date
            margin: 0
            color: var(--color-text)
            font-size: 0.8rem
            padding: 1rem
            padding-top: 0

        .approve-bar
            display: flex
            align-items: center
            gap: 1rem
            padding: 1rem
            background: #00000020
            border-bottom-left-radius: inherit
            border-bottom-right-radius: inherit

            .flex-1
                flex: 1
</style>