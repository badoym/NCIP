<template>
    <div class="p-2">
        <nav aria-label="breadcrumb card">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="text-black">Master Data</a></li>
            <li class="breadcrumb-item active text-black" aria-current="page">User</li>
        </ol>
        </nav>

        <div class="row">
            <div class="col-md-4">
                <div class="card" style="height: auto; ">
                    <div class="p-5">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" v-model="name" :disabled="isPassword"
                            :class="{ 'border border-danger' : errors.name }"
                            />
                            <p class="text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" v-model="email" :disabled="isPassword"
                            :class="{ 'border border-danger' : errors.email }"
                            />
                            <p class="text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                        </div>
                        <div class="form-group" v-show="isPassword || !isEdit">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" v-model="password"
                            :class="{ 'border border-danger' : errors.password }"
                            />
                            <p class="text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                        </div>
                        <div class="form-group" v-show="isPassword || !isEdit">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" v-model="password_confirmation"
                            :class="{ 'border border-danger' : errors.password_confirmation }"
                            />
                            <p class="text-danger" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</p>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div>
                                <div class="">
                                    <button v-if="isEdit || isPassword" v-on:click="cancelUpdate" type="button" class="btn btn-outline-danger">Cancel</button>
                                    <button v-if="!isEdit && !isPassword" v-on:click="createRecord" type="button" class="btn btn-primary">Add User</button>
                                    <button v-if="isPassword" v-on:click="saveChangePassword" type="button" class="btn btn-primary">Update Password</button>
                                    <button v-if="isEdit && !isPassword" v-on:click="updateRecord" type="button" class="btn btn-success">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
            <div class="col-md-8">
                <div class="card p-5" style="height: 83vh; overflow-y: scroll;">  
                    <div class="filter row align-items-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date-of-filing" class="form-label w-50">Date From:</label>
                                <input type="date" id="date-of-filing" class="form-control" v-model="transact_date1" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                    <label for="date-of-filing" class="form-label w-50">Date To:</label>
                                    <input type="date" id="date-of-filing" class="form-control" v-model="transact_date2" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="region" class="form-label w-50">Name</label>
                                <input type="text" id="region" class="form-control" v-model="filter_name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100 mt-3" v-on:click="filterData()"> <i class="fas fa-filter"></i> Filter</button>
                        </div>
                    </div>
                    <v-client-table :data="data" :columns="columns" :options="options" >
                        <template slot="actions" slot-scope="row">
                            <button class="btn btn-outline-warning" v-on:click="edit(row)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger" v-on:click="destroy(row)">
                            <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-outline-danger change-password-btn" v-on:click="changePasssword(row)">
                                <i class="fas fa-user-shield text-light"></i> 
                            </button>
                        </template>
                    </v-client-table>
                </div>
            </div>
        </div>
        <div class="vld-parent">
        <loading v-model:active="isLoading"
                :is-full-page="fullPage"/>
        </div>
  </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default{
  components: {
    Loading
  },
  data(){
    return {
        isLoading: false,
        fullPage: true,
        isEdit : false,
        errors : [],

        // Set dafault date form start of the month to date today
        transact_date1 : new Date(new Date().getFullYear(), new Date().getMonth(), 1).toLocaleDateString('en-CA'),
        transact_date2 :new Date().toLocaleDateString('en-CA'),

        selected_regions: '',
        filter_name : '',
        region_options: [],


        id : '',
        name : '',
        email : '',
        password : '',
        password_confirmation : '',
        isPassword : false,

        
        data: [],
        columns: ['id', 'name',, 'email', 'actions'],
        options: {
        headings: {
          id: 'ID',
          name: 'Name',
          actions: 'Actions'
        },
        templates: {
          es_amount: function(h, row) {
            return Number(row.qty) * Number(row.unit_cost);
          }
        },
        filterable: false,
        perPageValues: [], // Hides the dropdown
      },
    }
  },
  methods: {
    init() {
            this.name = '';
            this.email = '';
            this.password = '';
            this.password_confirmation = '';
            this.filter_name = '';
            this.errors = [];
        },
    show() {
        this.isLoading = true;
        axios.get('/users/show').then(function (res) {
            this.data = res.data.data;
        }
        .bind(this)).finally(() => {this.isLoading = false});
    },

    closeModal() {
        $("#create-modal").modal("hide");
    },

    create() {
        this.isEdit = false;
        this.isPassword = false;
        this.init();
        $("#create-modal").modal("show");
    },
    filterData() {
        this.isLoading = true;
        axios.post('/users/filterData', {
            date_from: this.transact_date1,
            date_to: this.transact_date2,
            name: this.filter_name
        }).then(response => {
            this.data = response.data.data;
        })
    },

    createRecord() {
        this.isLoading = true;
        axios.post('/users/store', {
            name : this.name,
            email : this.email,
            password : this.password,
            password_confirmation : this.password_confirmation,
        }).then(response => {
            this.$fire({
                title : 'Successfully Saved!',
                text : response.data.message,
                type : 'success',
                timer : 3000,
            })
            this.show();
            this.init();
            this.closeModal();
        }).catch(error => {
            this.$fire({
                title : 'Error Saving',
                text : error.response.data.message,
                type : 'warning',
                timer : 3000,
            })
            this.isLoading = false;
            this.errors = error.response.data.errors;
        }).finally(() => { this.isLoading = false})
    },

    edit(data) {
        this.isEdit = true;
        this.isPassword = false;
        this.id = data.row.id;
        this.name = data.row.name;
        this.email = data.row.email;
        $("#create-modal").modal("show");
    },

    updateRecord() {
        axios.put('/regions/update/' + this.id, {
            name: this.name,
        })
        .then(response => {
            // console.log(response);
            this.$fire({
                title: 'Successfully Updated!',
                text: response.data.message,
                type: 'success',
                timer: 3000,
            })
            this.show();
            this.init();
            $('#create-modal').modal('hide');
        }).catch(error => {
            this.$fire({
                title : 'Error Saving',
                text : error.response.data.message,
                type : 'warning',
                timer : 3000,
            })
            this.errors = error.response.data.errors;
        });
    },

    destroy(data) {
        if(confirm('Are you sure you want to delete this record?')) {

            axios.get('/regions/destroy/' + data.row.id)
            .then(response => {
                // console.log(response);
                this.$fire({
                    title : 'Successfully Deleted!',
                    text : response.data.message,
                    type : 'success',
                    timer : 3000,
                }).then( r => {
                    console.log("test");
                })
                this.show();
            }).catch(error => {
                if(error.response.status == 500){
                    this.$fire({
                        title : 'Error',
                        text : 'Internal Server Error',
                        type : 'warning',
                        timer : 3000,
                    })
                }
            this.errors = error.response.data.errors;
            });
        }
    },
    cancelUpdate(){
        this.isEdit = false;
        this.isPassword = false;
        this.init();
    },
    changePasssword(row){
        this.init();
        this.isPassword = true;
        this.id = row.row.id;
        this.name = row.row.name;
        this.email = row.row.email;
        console.log(row);
      },
    saveChangePassword(){
        this.loading = true;
        axios.post('users/changepassword' ,{
            id : this.id,
            password : this.password,
            password_confirmation : this.password_confirmation,
        }).then(response => {
            this.$fire({
                    title : 'Successfully Deleted!',
                    text : response.data.message,
                    type : 'success',
                    timer : 3000,
                }).then( r => {
                    console.log("test");
                })
            this.show();
            $('#change-pass-modal').modal('hide');
        }).catch(error => {
            this.$fire({
                title : 'Error',
                text : 'Internal Server Error',
                type : 'warning',
                timer : 3000,
            })
            this.errors = error.response.data.errors;

        }).finally(() => {this.loading = false})
    }
    },
    mounted() {
        this.isLoading = false;
        this.show();
        this.init();
    }
}

</script>

<style scoped>
.p-5 {
    padding: 3rem !important;
}

.card {
    margin-top: 1rem;
    box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
    border-radius: 10px;
}


.card-body {
    padding: 0!important;
}

.form-group {
    margin-bottom: 1rem;
}

.form-check {
    margin-top: 0.5rem;
}

.filter p,.filter button {
  font-size: 14px;
}

.breadcrumb {
    background-color: white;
    font-size: 16px;
    font-weight: bold;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    color: #6c757d;
    padding: 0 0.5rem;
}
</style>
