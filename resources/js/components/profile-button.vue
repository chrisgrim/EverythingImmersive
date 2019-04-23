<template>
	<div>
		<label @click="toggle = !toggle" class="profile-image" :style="{ backgroundImage: 'url(' + avatar + ')' }">
		</label>
		<ul v-show='toggle' class="subdropdown">
			<li>
				<a :href="'/user/'+ url">
					Profile
				</a>
			</li>
			<li>
				<a :href="'/myFavorites/'+ url">
					Your Favorites
				</a>
			</li>
			<li>
				<a :href="'/website-stats/'">
					Website Stats
				</a>
			</li>
			 <li>
			 	<a href="#" @click.prevent="logout">
			 		Logout
			 	</a>
			 </li>
			
		</ul>
	</div>
</template>

<script>
	import ImageUpload from './imageupload.vue';

	export default {
		props: ['user'],

		components: { ImageUpload },


		data() {
			return {
				avatar: this.user.avatar_path,
				userName: this.user.name,
				url: this.user.name,
				toggle:false,

			};

		},


		methods: {
			onLoad(avatar) {
				this.avatar = avatar.src;
				this.persist(avatar.file);
			},

			logout() {
				axios.post('/logout');
				window.location.reload();
			}

		}
	}
</script>



