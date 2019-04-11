<template>
	<div>
		<div>
			<form method="POST" enctype="multipart/form-data">
				<label class="imgclick" :style="{ backgroundImage: 'url(' + avatar + ')' }">
					<image-upload name="avatar" @loaded="onLoad"></image-upload>
				</label>
			</form>
		</div>
	</div>

</template>

<script>
	import ImageUpload from './imageupload.vue';

	export default {
		props: ['event'],

		components: { ImageUpload },

		data() {

			return {
				avatar: this.event.eventImagePath,
				submit: this.event.slug
			};

		},


		methods: {
			onLoad(avatar) {
				this.avatar = avatar.src;
				this.persist(avatar.file);
			},

			persist(avatar) {
				let data = new FormData();

				data.append('eventImage', avatar)
				axios.post('/create-your-event/' + this.event.slug + '/images', {
					data:this.data,
					_method: 'patch'
					})
					.then(() => flash('Image uploaded!'));
					
			}
		}
	}
</script>



