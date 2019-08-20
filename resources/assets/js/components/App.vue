<template>
	<div>
		<transition>
			<router-view></router-view>
		</transition>
	</div>
</template>

<script type="text/javascript">
	export default{
		mounted(){
			console.log('mounted');
		}
	}
</script>