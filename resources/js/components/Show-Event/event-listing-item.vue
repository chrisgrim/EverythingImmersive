<template>
	<div>
		<a :href="'/events/' + event.slug">
			<div class="event-grid">
				<div class="event-image">
					<div class="grid-background-image" :style="divBackground">
							<div class="heart-location">
								<svg viewBox="0 0 32 32" class="unhearted">
									<a :href="'/favorite/' + event.slug + '/login'">
										<path d="m23.99 2.75c-.3 0-.6.02-.9.05-1.14.13-2.29.51-3.41 1.14-1.23.68-2.41 1.62-3.69 2.94-1.28-1.32-2.46-2.25-3.69-2.94-1.12-.62-2.27-1-3.41-1.14a7.96 7.96 0 0 0 -.9-.05c-1.88 0-7.26 1.54-7.26 8.38 0 7.86 12.24 16.33 14.69 17.95a1 1 0 0 0 1.11 0c2.45-1.62 14.69-10.09 14.69-17.95 0-6.84-5.37-8.38-7.26-8.38"></path>
									</a>
								</svg>
							</div>
							<div>
								<favorite :event="event"></favorite>
							</div>
					</div>
				</div>
				{{ event.eventTitle }}
			</div>
			</a>
    </div>
</template>

<script>
	export default {
		props: {
			event: { type:Object },
			user: { type:Object },
		},

		data() {
			return {
				event: this.event,
				divBackground: `background-image: url("/storage/${this.event.thumbImagePath}");`
			}
		},

		methods: {

		}
    };
</script>