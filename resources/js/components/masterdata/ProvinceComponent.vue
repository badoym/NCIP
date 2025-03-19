<template>
  <div class="p-2">
    <nav aria-label="breadcrumb card">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Master Data</a></li>
        <li class="breadcrumb-item active" aria-current="page">Location</li>
        <li class="breadcrumb-item active" aria-current="page">Province</li>
    </ol>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card" style="height: auto; ">
                <div class="p-5">
                    <div class="form-group">
                        <label for="region_id">Region</label>
                        <select class="form-control" id="region_id" v-model="region_id"
                        :class="{ 'border border-danger' : errors.region_id }"
                        >
                            <option disabled selected value="">Select Region</option>
                            <option v-for="region in regions" :value="region.id">{{ region.name }}</option>
                        </select>
                        <p class="text-danger" v-if="errors.region_id">{{ errors.region_id[0] }}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Province</label>
                        <input type="text" class="form-control" id="name" v-model="name">
                        <p class="text-danger" v-if="errors.region_id">{{ errors.name[0] }}</p>

                    </div>

                    <div class="d-flex justify-content-end">
                        <div>
                            <div class="">
                                <button v-if=" !isEdit" v-on:click="createRecord" type="button" class="btn btn-primary">Add Province</button>
                                <button v-if="isEdit" v-on:click="cancelUpdate" type="button" class="btn btn-outline-danger">Cancel</button>
                                <button v-if="isEdit" v-on:click="updateRecord" type="button" class="btn btn-success">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
        <div class="col-md-8">
            <div class="card p-5" style="height: 83vh; overflow-y: scroll;">  
                <div class="filter row align-items-center">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date-of-filing" class="form-label w-50">Date From:</label>
                            <input type="date" id="date-of-filing" class="form-control" v-model="transact_date1" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                                <label for="date-of-filing" class="form-label w-50">Date To:</label>
                                <input type="date" id="date-of-filing" class="form-control" v-model="transact_date2" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="region" class="form-label">Region</label>
                            <select class="form-control" id="region_id" v-model="filter_region_id" v-on:change="onChangeProvinces">
                                <option value="" disabled>Select Region</option>
                                <option v-for="region in regions" :value="region.id">{{ region.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="name">Province</label>
                            <input type="text" class="form-control" id="name" v-model="filter_name">
                        </div>
                    </div>
                    <div class="col-md-2">
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
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components: {
        Loading
    },

    props: ['regions'],

    data() {
        return {
            isLoading: false,
            fullPage: true,
            isEdit : false,
            errors : [],
            filter_name : '',
            filter_region_id : '',

            //set default date from the first day of the month and the date today
            transact_date1: new Date(new Date().getFullYear(), new Date().getMonth(), 1).toLocaleDateString('en-CA'),
            transact_date2: new Date().toLocaleDateString('en-CA'),

            selected_regions: '',
            regions_option: [],
            provinces_option: [],

            id : '',
            region_id : '',
            name : '',
            province_id: '',
            data: [],
            columns: ['id', 'region_name', 'name', 'actions'],
            options: {
                headings: {
                    id: 'ID',
                    region_name: 'Region',
                    name: 'Province',
                    actions: 'Actions'
                },
                filterable: false,
            },
        }
    },
    methods: {
        init() {
            this.region_id = '';
            this.filter_region_id = '';
            this.name = '';
            this.isEdit = false;
            this.filter_name = '';
            this.errors = [];
        },
        show() {
            this.isLoading = true;
            axios.get('/provinces/show').then(function (res) {
                this.data = res.data.data;
            }.bind(this)).finally(() => { this.isLoading = false });
        },

        closeModal() {
            $("#create-modal").modal("hide");
        },
        filterData() {
            this.isLoading = true;
            axios.post('/provinces/filterData', {
                date_from: this.transact_date1,
                date_to: this.transact_date2,
                region_id: this.filter_region_id,
                name: this.filter_name,
            }).then(response => {
                this.data = response.data.data;
            })
        },
        onChangeProvinces(){
            this.name='';
        },
        create() {
            this.isEdit = false;
            this.init();
            this.errors = [];
            $("#create-modal").modal("show");
        },

        createRecord() {
            this.isLoading = true;
            axios.post('/provinces/store', {
                region_id : this.region_id,
                name : this.name,
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
            if (error.response?.status === 422) {
                // Handle validation errors
                this.handleValidationError(error.response.data.errors);
            } else if (error.response?.status === 400) {
                // Handle "already exists" error
                this.showErrorNotification(error.response.data.message);
            } else {
                // Handle unexpected errors
                this.showErrorNotification('An unexpected error occurred.');
            }
            }).finally(() => {
                this.isLoading = false;
            });
        },
        handleValidationError(errors) {
            this.errors = errors;
        },
        showErrorNotification(message) {
            this.$fire({
                title: 'Error',
                text: message,
                type: 'warning',
                timer: 3000,
            });
        },

        edit(data) {
            this.isEdit = true;
            this.id = data.row.id;
            this.region_id = data.row.region_id;
            this.name = data.row.name;
            this.errors = [];
            $("#create-modal").modal("show");
        },

        updateRecord() {
            axios.put('/provinces/update/' + this.id, {
                region_id : this.region_id,
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
            if (error.response?.status === 422) {
                // Handle validation errors
                this.handleValidationError(error.response.data.errors);
            } else if (error.response?.status === 400) {
                // Handle "already exists" error
                this.showErrorNotification(error.response.data.message);
            } else {
                // Handle unexpected errors
                this.showErrorNotification('An unexpected error occurred.');
            }
            }).finally(() => {
                this.isLoading = false;
            });

        },

        destroy(data) {
            if(confirm('Are you sure you want to delete this record?')) {

                axios.get('/provinces/destroy/' + data.row.id)
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
                    this.init();
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
            this.init();
        }
    },
    mounted() {
        this.isLoading = false;
        this.show();
        this.init();
        this.filterData();
    }
}

</script>

<style scoped>
.p-5 {
    padding: 3rem !important;
}

.card {
    margin-top: 1rem;
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
    font-size: 18px;
    font-weight: bold;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '>';
    color: #6c757d;
    padding: 0 0.5rem;
}
</style>
