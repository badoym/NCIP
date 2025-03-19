<template>
    <div class="p-2">
        <nav aria-label="breadcrumb card">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="#" class="text-black">Master Data</a></li>
            <li class="breadcrumb-item text-black" aria-current="page">Government Programs</li>
        </ol>
        </nav>

        <div class="row">
            <div class="col-md-4">
                <div class="card" style="height: auto; ">
                    <div class="p-5">
                        <div class="form-group">
                            <label for="name">Government Program</label>
                            <input type="text" class="form-control" id="name" v-model="name"
                            :class="{ 'border border-danger' : errors.name }"
                            />
                            <p class="text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
                        </div>
                        <div class="form-group">
                            <label for="name">Description</label>
                            <textarea type="text" class="form-control" rows="10"  id="name" v-model="description"
                            :class="{ 'border border-danger' : errors.description }"
                            />
                            <p class="text-danger" v-if="errors.description">{{ errors.description[0] }}</p>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Start Date</label>
                                    <input type="date" class="form-control" id="name" v-model="start_date"
                                    :class="{ 'border border-danger' : errors.start_date }"
                                    />
                                    <p class="text-danger" v-if="errors.start_date">{{ errors.start_date[0] }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">End Date</label>
                                    <input type="date" class="form-control"  id="name" v-model="end_date"
                                    :class="{ 'border border-danger' : errors.end_date }"
                                    />
                                    <p class="text-danger" v-if="errors.end_date">{{ errors.end_date[0] }}</p>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-check form-switch p-0" v-if="isEdit">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="toggleSwitch" v-model="status" @click="changeStatus">
                                    <label class="custom-control-label" for="toggleSwitch">
                                        {{ status ? 'ACTIVE' : 'NOT ACTIVE' }}
                                    </label>
                                </div>
                          </div>
                        <div class="d-flex justify-content-end">
                            <div>
                                <div class="">
                                    <button v-if=" !isEdit" v-on:click="createRecord" type="button" class="btn btn-primary bg-blue" style="">Add Program</button>
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
                                <label for="region" class="form-label w-50">Program</label>
                                <input type="text" id="region" class="form-control" v-model="filter_name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary bg-blue w-100 mt-3" v-on:click="filterData()"> <i class="fas fa-filter"></i> Filter</button>
                        </div>
                    </div>
                    <v-client-table :data="data" :columns="columns" :options="options" >
                        <template slot="actions" slot-scope="row" >
                            <div class="d-md-flex justify-content-center">
                                <button class="btn btn-outline-warning m-1" v-on:click="edit(row)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger m-1" v-on:click="destroy(row)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </template>
                        <template slot="status" slot-scope="{ row }">
                            <span v-if="row.status === 1" class="active bg-green"> Active</span>
                            <span v-else class="not-active">Not Active</span>
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

        filter_name : '',


        id : '',
        name : '',
        description : '',
        status : 0,
        // start_date : '',
        // end_date  : '',


        data: [],
        columns: ['id', 'name', 'description',  'status', 'actions'],
        options: {
        headings: {
          id: 'ID',
          name: 'Program',
          description: 'Description',
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
            this.filter_name = '',
            this.description = '';
            this.errors = [];
            // this.start_date = '';
            // this.end_date = '';
            this.isEdit = false;
        },
    show() {
        this.isLoading = true;
        axios.get('/governmentprograms/show').then(response=> {
            this.data = response.data.data;
        }).catch(error => {
            console.log(error);
        }).finally(() => { this.isLoading = false});
    },
    create() {
        this.isEdit = false;
        this.init();
    },
    filterData() {
        this.isLoading = true;
        axios.post('/governmentprograms/filterData', {
            date_from: this.transact_date1,
            date_to: this.transact_date2,
            name: this.filter_name,
        }).then(response => {
            this.data = response.data.data;
        })
    },

    createRecord() {
        this.isLoading = true;
        axios.post('/governmentprograms/store', {
            name : this.name,
            description : this.description,
            // start_date : this.start_date,
            // end_date : this.end_date,
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
        this.id = data.row.id;
        this.name = data.row.name;
        this.description = data.row.description;
        // this.start_date = data.row.start_date;
        // this.end_date = data.row.end_date;
        this.status = data.row.status;
    },

    updateRecord() {
        axios.put('/governmentprograms/update/' + this.id, {
            name: this.name,
            description: this.description,
            status : this.status,
            // start_date : this.start_date,
            // end_date : this.end_date,
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

            axios.get('/governmentprograms/destroy/' + data.row.id)
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
        this.init();
    },
    changeStatus(){
        this.status = !this.status;
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

.active{
    background-color: #5CB338;
    color: white;
    padding: 3px 20px;
    border-radius: 15px;
    font-size: 12px;
}

.not-active{
    background-color: #D9DFC6;
    color: white;
    padding: 3px 20px;
    border-radius: 15px;
    font-size: 12px;

}

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
