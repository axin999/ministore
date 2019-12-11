<template>
	<div>
			
<!-- 			<div v-if="!changepriceset" v-for="prices in priceinfo.pricestoedit" class="form-group">
				<label for="">{{ prices.priceset_type }}</label>
				<input  v-model="prices.price" class="form-control" type="" name="">
			</div>
 -->

			<div v-for="priceset in pricesetdata" class="form-group">
				<label for="">{{ priceset.priceset_type }}</label>
				<input  v-model="priceset.price" class="form-control" type="" name="">
			</div>
	
		
	</div>
</template>

<script>

	export default{
		data(){
			return{
				pricesetdata:"",
				/*changepriceset:false,*/
			}
		},
		props:["priceinfo"],
		methods:{
			getpriceset(){
				/*if(this.priceinfo.categoryid != this.priceinfo.oldcategoryid)
						{
							this.changepriceset = true;
						}
				else{
					this.changepriceset = false;
				};*/
				Axios.get('showpricesetprice',{
				  params: {
				  	itemid:this.priceinfo.id,
				    categoryid: this.priceinfo.categoryid
				}
  				})
				.then((data)=>{
					
						if(data.data.length===0){
							Axios.get('showpricesets',{params:{categoryid:this.priceinfo.categoryid}})
							.then((data)=>{
								console.log('data.data',data.data)
								this.pricesetdata = data.data;
								this.$emit('get-category',this.pricesetdata);

							})
							.catch()
						}
						else{
							this.pricesetdata = data.data;
							this.$emit('get-category',this.pricesetdata);
						}
					
					

				})
				.catch()
			},
			jumbo(value){
				this.pricesetdata = value;
			}
		},
		watch:{
				'priceinfo.categoryid': {
					handler: function (val, oldVal) {
					console.log('props2',this.priceinfo);
					
					this.getpriceset();
						
					},

				deep: true

				}

/*			priceinfo:function(){
				if (this.priceinfo) {
					this.$emit('get-category',this.priceinfo.category);
					console.log('priceinfoinpriceset',this.priceinfo);
				}
			}*/
		},
		created(){
		console.log('props',this.priceinfo);
			
		}
	}

</script>