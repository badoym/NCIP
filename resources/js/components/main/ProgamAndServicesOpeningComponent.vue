<template>
    <div class="p-2">
        <nav aria-label="breadcrumb card">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="text-black">Progams & Openings</a></li>
        </ol>
        </nav>
        <!-- filter -->
        <div class="card px-4  py-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="filter row align-items-center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date-of-filing" class="form-label w-50">Created From:</label>
                                <input type="date" id="date-of-filing" class="form-control" v-model="transact_date1" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                    <label for="date-of-filing" class="form-label w-50">Created To:</label>
                                    <input type="date" id="date-of-filing" class="form-control" v-model="transact_date2" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="region" class="for  m-label w-50">Opening Type</label>
                                <select name="opening_type" id="opening_type" v-model="filter_opening_type" class="form-control" >
                                    <option value="">All</option>
                                    <option value="1">Government Program</option>
                                    <option value="2">Service</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100 mt-3 bg-blue" v-on:click="filterData()"> <i class="fas fa-filter"></i> Filter</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success w-100 mt-3 p-2" v-on:click="create()"> <i class="fas fa-plus-circle"></i>  Create Opening</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl p-3" role="document">
                    <div class="modal-content">
                        <h5 class="modal-title text-center bg-light  pt-4 pb-2" style="font-weight:bold;">{{ selectedItem.length  ==  0 ?  'Select a opening' : 'Program/Services Details'}}</h5>
                        <div class="modal-body">
                            <div v-if="selectedItem.length  ==  0">
                                <div class="form-group">
                                    <label for="opening_type" class="form-label">Opening For: </label>
                                    <select name="opening_type" id="opening_type" v-model="opening_type" class="form-control" v-on:change="onChangeOpening">
                                        <option value="">Select a opening</option>
                                        <option value="1">Government Program</option>
                                        <option value="2">Service</option>
                                    </select>
                                </div>

                                <div class="data" v-if="data.length > 0 " style="height: 630px; overflow-y:scroll; overflow-x:hidden">
                                    <h5 class="modal-title text-center  pt-2 pb-2" style="font-weight:bold;">{{ opening_type == 1 ? 'Government Program List' : 'Services List' }}</h5>
                                    <div class="row">
                                        <div class="col-md-4" v-for="item in data">  
                                            <div class="card " style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;">
                                                <div class="card-header p-3 ">
                                                    <p class="text-bold m-0 p-0">{{ item.name  }}</p>
                                                </div>
                                                <div class="card-body p-3">
                                                    <article class="p-3">
                                                        Description : {{ item.description }}
                                                    </article>
                                                </div>
                                                <div class="card-footer p-3">
                                                    <button class="btn btn-outline-primary w-100" v-on:click="selectProgram(item)">Select</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p v-else class="text-center">No Data to show</p>

                            </div>
                            <div v-else>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card p-3" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;">
                                            <p class="text-danger" v-if="errors.id">{{ errors.id[0] }}</p>
                                            <div class="card-header">
                                                <h3 style="font-weight: bold;">{{ selectedItem.name }}</h3>
                                            </div>
                                            <div class="card-body">
                                                <article class="p-3">
                                                    <span style="font-weight: bold;">Description:</span> {{  selectedItem.description }}
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-5" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;">
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" class="form-control" v-model="start_date">
                                                <p class="text-danger" v-if="errors.start_date">{{ errors.start_date[0] }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="date" class="form-control" v-model="end_date">
                                                <p class="text-danger" v-if="errors.end_date">{{ errors.end_date[0] }}</p>
                                            </div>

                                            <button class="btn btn-primary" v-on:click="save">Save</button>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- content -->
        <div class="row">
            <div class="col-md-4" v-for="item in list">  
                <div class="card p-3" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;">
                    <div class="card-header p-3 d-flex justify-content-between">
                        <div class="w-75">
                            <p class="text-bold m-0 p-0">{{ item.name  }}</p>
                            <p class="m-0 p-0 text-secondary">{{ item.government_program_id ? 'Government Programs' : 'Service'}}</p>
                            <p class="m-0 p-0 text-secondary">Creation Date: {{ formatDate(item.created_at)}}  </p>
                            <p class="m-0 p-0 text-secondary"> {{ item.government_program_id ? 'Program Duration' : 'Service Duration'}} : {{ formatDate(item.start_date) }} - {{  formatDate(item.end_date) }}  </p>
                        </div>
                        <div class="d-flex justify-content-end w-25">
                            <p class="m-0 p-0 text-secondary"> Applied : {{ item.total_applications}}</p>
                        </div>
                      
                    </div>
                    <div class="card-body p-3">
                        <article class="p-3">
                            {{ item.description }}
                        </article>
                    </div>
                    <div class="card-footer p-3">
                        <button class="btn btn-outline-danger w-100 my-1" v-on:click="cancelProgram(item)">Cancel {{ item.government_program_id ? ' Program' : ' Service'}} </button>
                        <button class="btn btn-primary w-100 my-1" v-on:click="viewProgram(item)">View {{ item.government_program_id ? ' Program' : ' Service'}} </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl p-3" role="document">
                    <div class="modal-content">
                        <h5 class="modal-title text-center bg-light  pt-4 pb-2" style="font-weight:bold;">Program/Service Details</h5>
                        <div class="modal-body">
                            <div class="col-md-12" >  
                                <div class="p-3" >
                                    <div class="card-header p-3 d-flex justify-content-between">
                                        <div class="w-75">
                                            <p class="text-bold m-0 p-0" style="font-size: 20px;">{{ viewSelectedItem.name  }}</p>
                                            <p class="m-0 p-0 text-secondary" style="font-size: 16px;">{{ viewSelectedItem.government_program_id ? 'Government Programs' : 'Service'}}</p>
                                            <p class="m-0 p-0 text-secondary" style="font-size: 16px;">Creation Date: {{ formatDate(viewSelectedItem.created_at)}}  </p>
                                            <p class="m-0 p-0 text-secondary" style="font-size: 16px;"> {{ viewSelectedItem.government_program_id ? 'Program Duration' : 'Service Duration'}} : {{ formatDate(viewSelectedItem.start_date) }} - {{  formatDate(viewSelectedItem.end_date) }}  </p>
                                        </div>
                                       
                                    </div>
                                    <div class="">
                                        <div class="card-header pb-2 " style="height: 500px; overflow-y: scroll;">
                                            <p class="m-0 p-0 text-secondary mb-3" style="font-size: 16px;">People Avail/Applied</p>
                                            <v-client-table :data="applicant_list" :columns="columns" :options="options" >
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
                                    <div class=" p-3 d-flex justify-content-center">
                                        <button class="btn btn-outline-primary w-25 " v-on:click="closeView()">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- preloader -->
        <div class="vld-parent" style="z-index: 9999!important;">
        <loading v-model:active="isLoading"
                :is-full-page="fullPage"/>
        </div>
  </div>
</template>

<script>
import axios from 'axios';
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

        filter_opening_type : '',
        // Set dafault date form start of the month to date today
        transact_date1 : new Date(new Date().getFullYear(), new Date().getMonth(), 1).toLocaleDateString('en-CA'),
        transact_date2 :new Date().toLocaleDateString('en-CA'),

        opening_type : '',
        selectedItem : [],
        viewSelectedItem : [],
        data : [],
        list : [],
        applicant_list : [],

        start_date : '',
        end_date : '',

        data: [],
        columns: ['id', 'name', 'address', 'group', 'date_applied'],
        options: {
        headings: {
          id: 'ID',
          name: 'Fullname',
          adddress: 'Address',
          group: 'Ethnicity',
          date_applied : 'Date Applied',
        },
        filterable: false,
        perPageValues: [], // Hides the dropdown
      },
      
    }
  },
  methods: {
    init() {
        this.opening_type = '';
        this.selectedItem = [];
        this.data = [];
        this.start_date =  '';
        this.end_date =  '';
    },
    formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
    },
    showData(){
        axios.get('/programandserviceopenings/show').then(response => {
            this.list = response.data.data;
        })

    },
    closeModal() {
        $("#create-modal").modal("hide");
    },
    create() {
        this.init();
        $("#create-modal").modal("show");
    },
    filterData(){
        const obj = {
            filter_opening_type : this.filter_opening_type,
            date_from : this.transact_date1,
            date_to : this.transact_date2,
        };
        axios.post('/programandserviceopenings/filter',  obj).then(response => {
            this.list = response.data.data;
        }).catch(error => {
            console.log(error);
        })
    },
    cancelUpdate(){
        this.isEdit = false;
        this.init();
    },
    onChangeOpening(){
        this.isLoading = true;
        axios.get('/programandserviceopenings/onchangeopening/' + this.opening_type).then(response => {
            this.data = response.data.data;
        }).catch(error => {
            console.log(error);
        }).finally(() => { this.isLoading = false});
    },
    selectProgram(item){
        this.selectedItem = item;
      
    },
    viewProgram(item){
        this.viewSelectedItem = item;
        this.isLoading = true;
        axios.get('programandserviceopenings/applicants/' + item.id).then(response => {
            this.applicant_list = response.data.data;
            $('#view-modal').modal('show');
        }).catch(error => {
            this.$fire({
                title : 'Error Saving',
                text : error.response.data.message,
                type : 'warning',
                timer : 3000,
            })
            this.errors = error.response.data.errors;
        }).finally(() => { this.isLoading = false});
    },
    save(){
        const obj = {
            opening_type : this.opening_type,
            start_date : this.start_date,
            end_date : this.end_date,
            id : this.selectedItem.id,
        }

        this.isLoading = true;
        axios.post('/programandserviceopenings/store', obj).then(response => {
            this.$fire({
                title : 'Successfully Saved!',
                text : response.data.message,
                type : 'success',
                timer : 3000,
            });
            this.showData();
            this.init();
            $("#create-modal").modal("hide");
        }).catch(error => {
            this.errors = error.response.data.errors;
        }).finally(() => { this.isLoading = false});

    },
    closeView()
    {
        $('#view-modal').modal('hide');
    },
    cancelProgram(item){
        axios.get('programandserviceopenings/cancelprogram/' + item.id).then(response => {
            this.$fire({
                title : 'Successful',
                text : response.data.message,
                type : 'success',
                timer : 3000,
            });
            this.showData();
            this.init();
        }).catch(error => {
            this.$fire({
                title : 'Error Saving',
                text : error.response.data.message,
                type : 'warning',
                timer : 3000,
            })
            this.errors = error.response.data.errors;
        }).finally(() => { this.isLoading = false});
    }
  
    },
    mounted() {
        this.showData();
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
