<template>

<div class="row">

<div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Price List</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table v-for="item in pricelist" class="table table-hover">
                    <thead class="">
                        <th colspan="1000" class="bg-success">{{ item[0].name }}
                            <span class="float-right">
                                <a @click="editpricelist(item)"> <i class="fa fa-edit text-blue"></i></a>
                                <a ><i class="fa fa-trash text-red"></i></a>
                            </span>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td v-for="price in item" class="h3">{{ price.priceset_type }}</td>
                        </tr>
                        <tr>
                            <td v-for="price in item">{{ price.price }} pesos</td>
                        </tr>
                    </tbody>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>


            <!-- Modal -->
            <div class="modal fade" id="editPriceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="updateItemlist()">
                        <div class="modal-body">
                            
                            <div class="row">
                                
                                    <div class="col col-md-6">
                                        <div class="form-group">
                                            <label for="name">Item Name:</label>
                                            <input v-model="form.name" class="form-control" type="text" name="name">
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Item Description:</label>
                                            <input v-model="form.description" class="form-control" type="text" name="description">
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Item Quantity:</label>
                                            <input class="form-control" type="text" name="quantity">
                                        </div>
                                    </div>

                                    <div class="col col-md-6">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select  @change="getSelectVal()" ref="category_select" class="form-control">
                                                <option  class="hidden" selected="" v-bind:value="firstelementofprice.category_id">
                                                       <!--  {{  this.form.pricestoedit[0].id }}    -->
                                                       {{ firstelementofprice.category_name }}                 
                                                </option>
                                                <option v-for="categories in categorylist"  v-bind:value="categories.id" v-if="firstelementofprice.category_id != categories.id" class="dropdown-item">
                                                    {{ categories.category_name }}
                                                </option>

                                            </select>
                                        </div>
                                        
                                        <priceset v-bind:priceinfo="form" v-on:get-category="priceset_emit"></priceset>

                                        
                                    </div>
                            </div>
                            
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
</div>

</template>

<script>

import Priceset from './Priceset.vue';

function groupBy(array, key){
  const result = {}
  array.forEach(item => {
    if (!result[item[key]]){
      result[item[key]] = []
    }
    result[item[key]].push(item)
  })
  return result
};



    export default {
        components:{
            'priceset':Priceset,
            'sample':'Sample',
        },
        data(){
            return {
                pricesetcomponent:'priceset',
                pricelist:{},
                category:{},
                firstelementofprice:{},
                form: new Form({
                    id:'',
                    name:'',
                    description:'',
                    pricetype:'',
                    price:'',
                    categoryid:'',
                    oldcategoryid:'',
                    categoryname:'',
                    pricestoedit:[],
                }),
                defaultform:{},
            }
        },
        methods:{
            async loadPriceList(){
                var self = this;
                /*Axios.get("showitemlist").then((data) => (this.pricelist = data));*/
                await Axios.get("showitemlist").then(function(response){
                    self.pricelist = groupBy(response.data,'id');                    
                });
                 
                
            },
            async editpricelist(item){
                $('#editPriceModal').modal('show');
                Axios.get("getcategory").then((data) => (this.category = data.data));
                this.form.id = item[0].id;
                this.form.name = item[0].name;
                this.form.description = item[0].description;
                this.form.pricestoedit = JSON.parse(JSON.stringify(item));
                this.firstelementofprice = this.form.pricestoedit[0];
                this.form.categoryname = this.form.pricestoedit[0].category_name;
                this.form.categoryid = this.form.pricestoedit[0].category_id;
                this.form.oldcategoryid = this.form.pricestoedit[0].category_id;
                this.form.price =  _.map(item, 'price');
                this.defaultform = this.form;
                console.log('defaultform',this.defaultform);
                console.log('item', item);
                console.log('pricestoedit', this.form);
                console.log('firstelementofprice', this.firstelementofprice);

                

            },
            updateItemlist(){
                this.$Progress.start();
                this.form.put('updateitemlist/'+this.form.id)
                .then((res) => {
                    console.log(res.data);
                    $('#editPriceModal').modal('hide');
                    this.$Progress.finish();

                })
                .catch(()=> {

                })
                
            },
            priceset_emit(valueemit){
                console.log('sampleemit',valueemit);
                this.form.pricestoedit = valueemit;
            },
            getSelectVal() {
            this.form.categoryid = this.$refs.category_select.value;
            console.log('reeeeeeeeeeeeeeeeefsss',this.$refs.category_select.value);
            console.log('categoryid',this.category)
            
        }
        },
        watch:{
            form:{
                handler:function(newValue){
                    if(this.defaultform == newValue){
                        console.log('itschanging',newValue)
                    }
                    
                },
                deep:true
            }
        },
            created(){
                this.loadPriceList();

                //var parsedyourElement = JSON.parse(JSON.stringify(this.fucker));
                //console.log('fucker', JSON.parse(JSON.stringify(this.pricelist)));
                //console.log('dollar',this.$data.pricelist);
                //console.log(JSON.stringify(this.pricelist, null, 2));
                //console.log('lol',this.pricelist);

            },
            computed:{
                groups(){
                    return _.groupBy(this.pricelist.data, 'id') 
                    console.log('groupcomputed',this.pricelist.category_select.value);
                },
                categorylist(){
                    return this.category;
                },
            }

    }


</script>
