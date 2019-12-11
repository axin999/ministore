<template id="user-list">
<div class="container">
<div v-if="!$gate.isAdmin()">
	<not-found></not-found>
</div>
<div class="row" v-if="$gate.isAdmin()">
	

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Price List</h3>

                <div class="card-tools">
					<button type="button" class="btn btn-success" @click="newModal" data-target="#addUserModal">
						Addn New<i class="fas fa-user-plus fa-fw"></i>
					</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                   <tr v-for="(user,index) in users.data">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name | capitalize }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type }}</td>
                      <td>{{ user.created_at | timeToStrFromat }}</td>
                      <td>
                      	<a href="#" @click="editModal(user)"><i class="fa fa-edit text-blue"></i></a>
                      	/
                      	<a href="#" @click="deleteUser(user.id)"><i class="fa fa-trash text-red"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
				<div class="card-footer">
					<pagination :data="users" @pagination-change-page="getResults"></pagination>
				</div>
            </div>
            <!-- /.card -->
          </div>

			<!-- Modal -->
			<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">Edit User</h5>
			        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">Add New</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
					<form @submit.prevent="editmode ? updateUser() : addUser()">
						<div class="modal-body">
							<div class="form-group">
								<input v-model="form.name" type="text" name="name"
								placeholder="Username"
								class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
								<has-error :form="form" field="name"></has-error>
							</div>
							<div class="form-group">
								<input v-model="form.email" type="email" name="email"
								placeholder="Email Address"
								class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
								<has-error :form="form" field="email"></has-error>
							</div>
							<div class="form-group">
								<textarea v-model="form.bio" type="text" name="bio"
								placeholder="Short bio for user (optional)"
								class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
								<has-error :form="form" field="bio"></has-error>
							</div>
							<div class="form-group">
								<select v-model="form.type" type="text" name="type"
									class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
									<option value="Select User Role"></option>
									<option value="admin">Admin</option>
									<option value="user">User</option>
									<option value="owner">Owner</option>
								</select>
								<has-error :form="form" field="type"></has-error>
							</div>
							<div class="form-group">
								<input v-model="form.password" type="password" name="password"
								placeholder="password"
								class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
								<has-error :form="form" field="password"></has-error>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button v-if="editmode" type="submit" class="btn btn-primary btn-success">Update</button>
							<button v-if="!editmode" type="submit" class="btn btn-primary">Create</button>
						</div>
					</form>
			    </div>
			  </div>
			</div>
</div>
</div>

</template>

<!--<script>
	export default{
		data:function(){
			return {users:''};
		},
		created:function(){
			let uri = 'http://ministore.com/users';
			Axios.get(uri).then((response) => {
				this.users = response.data;
			});
		},
		computed: {
			filteredUsers:function(){
				if(this.users.length){
					return this.users;
				}
			}
		}
	}
</script>
-->
<script>
	export default{
		data(){
			return{
				editmode:true,
				users:{},
				form: new Form({
					id:'',
					name:'',
					email:'',
					password:'',
					type:'',
					bio:'',
					photo:''
				})
			}		
		},
		methods:{
			getResults(page = 1) {
			axios.get('api/users?page=' + page)
				.then(response => {
					this.users = response.data;
				});
			},
			updateUser(id){
				this.$Progress.start();
				this.form.put('api/users/'+this.form.id)
				.then(()=>{
					$('#addUserModal').modal('hide');
					swal.fire("Updated","Update success.", "success");
					this.$Progress.finish();
					VueFire.$emit('AfterCreate');
				})
				.catch(()=>{
					swal.fire("failed","There are something wrong.", "warning");
				})
			},

			editModal(user){
				this.editmode = true;
				this.form.reset();
				$('#addUserModal').modal('show');
				this.form.fill(user);
			},
			newModal(){
				this.editmode = false;
				this.form.reset();
				$('#addUserModal').modal('show');
			},
			deleteUser(id){
				swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					this.form.delete('api/users/'+id).then(()=>{
						if (result.value) {
						swal.fire(
							'Deleted!',
							'Your file has been deleted.',
							'success'
							)
						VueFire.$emit('AfterCreate');
						}
						
					})
				}).catch(()=>{
					swal.fire("failed","There are something wrong.", "warning");
				});
			},
			addUser(){
				this.$Progress.start();

				this.form.post('api/users')
				.then(() => {
                    VueFire.$emit('AfterCreate');
                    $('#addUserModal').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'User Created successfully'
                    });


				this.$Progress.finish();
				})
				 .catch(() => {
                    this.$Progress.fail()
                });

			},
			loadUsers(){
				if (this.$gate.isAdmin()) {
					Axios.get("api/users").then(({data}) => (this.users = data));
				}
				
				
				
			}
		},
		created(){
			VueFire.$on('searching',()=>{
				let query = this.$parent.search;
				Axios.get('api/findUser?q=' + query)
				.then((data) =>{
					this.users = data.data

				})
				.catch(()=>{
					swal.fire({
						title:"Search Fail",
						text:"Something is not right",
						type:"warning",
						});
				})
			})

			 	this.loadUsers();
			 	VueFire.$on('AfterCreate', () => {
			 		this.loadUsers();
			 		
			 	});


			 	//setInterval(()=>this.loadUsers(),10000);
		},
		filters: {
		capitalize: function (value) {
			if (!value) return ''
			value = value.toString()
			return value.charAt(0).toUpperCase() + value.slice(1)
			}
		},
}
</script>