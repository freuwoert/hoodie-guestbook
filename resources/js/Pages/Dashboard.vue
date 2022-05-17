<template>
    <Head title="Admin"/>

	<header class="dashboard-header">
		<h1>Dashboard</h1>
		<mui-button variant="contained" size="small" color="error" icon-left="logout" label="Logout" @click="logout"/>
	</header>

	<div class="options">
		<mui-toggle class="filter" type="switch" no-border prepend-label="Öffentlich" prepend-value="public" v-model="filter" append-value="private" append-label="Privat"/>
		<mui-toggle class="filter" type="checkbox" no-border v-model="onlyPending" append-label="Nur unbearbeitete"/>
	</div>
	
	<div class="container">
		<div class="limiter">
			<div class="comment-wrapper" v-if="filter === 'public'">
				<comment v-for="entry in filteredEntries" :key="entry.id" :data="entry" moderation @deny="handleEntry($event.id, 'denied')" @approve="handleEntry($event.id, 'approved')"/>
			</div>
			<div class="comment-wrapper" v-if="filter === 'private'">
				<comment v-for="entry in filteredEntries" :key="entry.id" :data="entry"/>
			</div>
		</div>
	</div>
</template>

<script>
	import { Head } from '@inertiajs/inertia-vue3'
	import Comment from '@/components/Comment'

    export default {
		data() {
			return {
				entries: [],
				filter: 'public',
				onlyPending: false,
			}
		},

		mounted() {
			axios.get('/api/entries/all')
			.then(response => {
				this.entries = response.data
				console.log(response.data)
			})
			.catch(error => {
				console.log(error.response)
			})
		},

		computed: {
			filteredEntries() {
				let filters = this.onlyPending ? ['pending'] : ['approved', 'denied', 'pending']
				return this.entries.filter(e => filters.includes(e.status)).filter(e => e.policy === this.filter)
			}
		},

		methods: {
			handleEntry(id, status) {
				axios.put('/api/entries/'+id, { status })
				.then(response => {
					this.entries[this.entries.findIndex(entry => entry.id === id)] = response.data
				})
				.catch(error => {
					console.log(error.response)
				})
			},

			logout() {
				axios.post('/logout')
				.then(response => {
					window.location.href = '/'
				})
				.catch(error => {
					console.log(error.response)
				})
			},
		},

		components: {
			Head,
			Comment,
		},
    }
</script>

<style lang="sass" scoped>
	.container
		width: 100%

	.limiter
		padding: 0 1rem
		max-width: 600px
		margin: 0 auto
		display: block
		line-height: 1.5

	header.dashboard-header
		background: var(--color-background-secondary)
		height: 4rem
		width: 100%
		display: flex
		align-items: center
		padding: 0 1rem
		position: fixed
		top: 0
		left: 0
		z-index: 10
		box-shadow: var(--shadow-elevation-low)

		h1
			font-family: 'Inter'
			font-size: .8rem
			font-weight: 500
			text-transform: uppercase
			letter-spacing: 0.05rem
			flex: 1

	.options
		display: flex
		align-items: center
		justify-content: flex-start
		padding: 0 1rem
		gap: 1rem
		overflow: auto
		white-space: nowrap
		position: fixed
		top: 4rem
		left: 0
		width: 100%
		height: 3rem
		z-index: 9
		background: var(--color-background)

		.filter
			border-radius: 5rem
			background: var(--color-background-secondary)
			box-shadow: var(--shadow-elevation-low)
			height: 2.2rem
			min-height: 0
			padding: 0 .6rem

	.comment-wrapper
		gap: 1rem
		display: flex
		flex-direction: column
		margin-top: 7rem
		padding: 1rem 0

	.small
		font-size: 0.8rem
</style>
