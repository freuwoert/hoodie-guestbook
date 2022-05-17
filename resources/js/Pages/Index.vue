<template>
    <Head title="Welcome"/>

	<header>
		<div class="limiter">
			<img class="profile-image" src="/images/morris.jpg" alt="Morris Punkt JPG">
		</div>
	</header>
	
	<div class="container info-container">
		<div class="limiter">
			
			<h1>Hey, was geht!</h1>
			
			<p>
				Ich bin Morris – der Mensch, der diesen Hoodie trägt.<br><br>

				Cool, dass du meinen QR Code gescannt hast. Wenn du willst, kannst du eine Nachricht in das Hoodie-Gästebuch posten.<br><br>

				Oder du schreibst mir auf Discord:<br><br>
			</p>

			<mui-button variant="contained" icon-left="person_add" label="Maurice#1950" @click="copyDiscordTag()" />
		</div>
	</div>

	<div class="container comment-container">
		<div class="limiter">
			<comment v-for="entry in entries" :key="entry.id" :data="entry"/>
		</div>
	</div>

	<div class="container input-container">
		<div class="limiter">
			<button class="icon-button" @click="$refs.social.open()">share</button>
			<button class="icon-button main" @click="$refs.form.open()">add</button>
			<button class="icon-button" @click="$refs.legal.open()">info</button>
		</div>
	</div>



	<popup ref="social">
		<mui-button variant="text" icon-left="person_add" label="Discord ID" @click="copyDiscordTag()"/>
	</popup>

	<popup ref="form">
		<form class="form" @submit.prevent="postComment">
			<!-- <mui-button style="margin-left: auto" variant="text" color="error" icon-right="close" label="Schließen" @click="$refs.form.close()"/> -->
			<mui-toggle type="switch" class="policy-select" no-border prepend-value="public" v-model="policy" append-value="private">
				<template #appendLabel>
					<b>Privat verschicken</b><br>
					<span>Nur ich kannst deine Nachricht sehen</span>
				</template>
			</mui-toggle>
			<mui-input type="text" label="Dein Name" no-border v-model="name" max="40" />
			<mui-input type="textarea" class="content-input" label="Deine Nachricht" no-border v-model="content" max="1000" />
			<mui-button type="submit" icon-right="send" label="Ab damit"/>
		</form>
	</popup>

	<popup ref="legal">
		<mui-button variant="text" icon-left="info" label="Legal Disclosures"/>
		<mui-button variant="text" icon-left="privacy_tip" label="Privacy Policy"/>
	</popup>
</template>

<script>
	import { Head } from '@inertiajs/inertia-vue3'
	import Comment from '@/components/Comment'
	import Popup from '@/components/Popup'

    export default {
		data() {
			return {
				entries: [],
				name: '',
				content: '',
				policy: 'public',
			}
		},

		mounted() {
			axios.get('/api/entries')
			.then(response => {
				this.entries = response.data
				console.log(response.data)
			})
			.catch(error => {
				console.log(error.response)
			})
		},

		methods: {
			copyDiscordTag() {
				navigator.clipboard.writeText('Maurice#1950')
			},

			postComment() {
				axios.post('/api/entries', {
					name: this.name,
					content: this.content,
					policy: this.policy,
				})
				.then(response => {
					this.name = ''
					this.content = ''
					this.policy = 'public'
					this.$refs.form.close()
				})
				.catch(error => {
					console.log(error.response)
				})
			},
		},

		components: {
			Head,
			Comment,
			Popup,
		},
    }
</script>

<style lang="sass" scoped>
	.container
		width: 100%

	header
		position: relative
		z-index: 1
		background: var(--color-primary)

		.profile-image
			height: 6rem
			width: 6rem
			border-radius: 50%
			display: inline-block
			margin-top: -1.5rem
			transform: translateY(calc(50% + .3rem))
			border: .3rem solid var(--color-background-secondary)

	.info-container
		background: var(--color-background-secondary)
		padding-block: 3.5rem 1rem
		box-shadow: var(--shadow-elevation-medium)

		p
			margin: 0
			font-size: .9rem

		h1
			margin-bottom: 1rem
			font-family: 'Short Stack', sans-serif

		.discord-button,
		a
			color: var(--color-link)
			text-decoration: none

	.comment-container
		padding-block: 2rem
		padding-bottom: 6rem

		.limiter
			display: flex
			flex-direction: column
			gap: 2rem

	.input-container
		background: var(--color-background-secondary)
		box-shadow: 0 -1px 3px #00000050
		padding-block: .75rem
		position: fixed
		bottom: 0
		left: 0
		width: 100%

		.limiter
			display: flex
			justify-content: space-around
			
			.icon-button
				color: white
				background: transparent
				border: none
				height: 3rem
				width: 3rem
				border-radius: 50%
				font-size: 1.25rem
				font-family: var(--mui-icon-font)
				display: grid
				place-content: center

				&.main
					font-size: 2rem
					background: var(--color-primary)
					color: var(--color-primary-contrast)

	.form
		width: 100%
		background: var(--color-background)
		border-radius: 1rem 1rem 0 0
		padding: 0 1rem
		display: flex
		flex-direction: column
		gap: 1rem
		--mui-background: var(--color-background-secondary)

		.policy-select
			background: var(--color-background-secondary)
			height: 3rem
			margin-bottom: 1rem
			justify-content: flex-start

		.content-input
			--base-height: 10rem
</style>
