<template>
    <!-- <div class="py-5 px-3">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">

                <div class="inner">
                <h3>65</h3>

                <p>Overall Applications</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53</h3>
                <p>Active Government Programs</p>
              </div>
              <div class="icon">
                <i class="fas fa-hand-holding-heart"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>Active Services</p>
              </div>
              <div class="icon">
                <i class="fas fa-hands-helping"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>150</h3>
                    <p>Registered User</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
          </div>
        </div>
    </div> -->
    <div class="card ">
      <div class="d-flex align-items-center justify-content-center" style="height: 90vh; ">
        <div>
          <p class="m-0 p-0">Welcome to</p>
          <h3>NCIP Mabinay System </h3>
          <p>Online Verification System</p>
        </div>

    </div>
    </div>


</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>
   .card {
        height: 90vh;
        padding: 0!important;
        margin: 0!important;
        position: relative;
        z-index: 1;
        background-image: url('/images/mabinay_bg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Adjust the opacity as needed */
        z-index: -1;
    }

    .card h3{
      color: white;
      font-weight: 900;
      font-size: 50px;
    }
    .card p{
      text-align: center;
      color: white;
      font-size: 30px;

    }
</style>
