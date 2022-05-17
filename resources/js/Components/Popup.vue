<template>
    <div class="popup-wrapper" :class="{'open': isOpen}">
		<div class="background" @click="close()"></div>
		<div class="content">
            <slot></slot>
        </div>
	</div>
</template>

<script>
    export default {
        data() {
            return {
                isOpen: false,
            }
        },
        
        methods: {
            open() {
                this.isOpen = true
            },
            
            close() {
                this.isOpen = false
            },
        },
    }
</script>

<style lang="sass">
    .popup-wrapper
        .content
            > button
                --primary: var(--color-text) !important
                height: 4rem !important
                border-radius: 0 !important
                justify-content: flex-start
                border-bottom: 1px solid #ffffff40

                &:last-of-type
                    border-bottom: none !important
</style>

<style lang="sass" scoped>
    .popup-wrapper
        position: fixed
        z-index: 100
        bottom: 0
        left: 0
        height: 100%
        width: 100%
        pointer-events: none

        &.open
            pointer-events: all

            .background
                opacity: 1

            .content
                transform: translate(-50%, 0)

        .background
            position: absolute
            bottom: 0
            left: 0
            height: 100%
            width: 100%
            background: rgba(0, 0, 0, 0.8)
            opacity: 0
            transition: all 300ms

        .content
            position: absolute
            bottom: 0
            left: 50%
            width: 100%
            max-width: 600px
            background: var(--color-background)
            box-shadow: 0 6rem 0 var(--color-background)
            padding-block: 1rem
            border-radius: 1rem 1rem 0 0
            display: flex
            flex-direction: column
            transform: translate(-50%, 100%)
            transition: all 400ms cubic-bezier(0.68, -0.55, 0.27, 1.55)
</style>