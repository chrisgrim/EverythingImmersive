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
		props: ['user'],

		components: { ImageUpload },

		data() {

			return {
				avatar: this.user.avatar_path

			};

		},


		methods: {
			onLoad(avatar) {
				this.avatar = avatar.src;
				this.persist(avatar.file);
			},

			persist(avatar) {
				let data = new FormData();

				data.append('avatar', avatar)
				axios.post(`/user`, data)
					.then(() => flash('Avatar uploaded!'));
			}
		}
	}
</script>



