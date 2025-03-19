<template>
    <div class="py-3">
        <div class="forum-container">
            <div class="forum-box">
              <div class="forum-header">Discussion</div>
              <div class="forum-body ">
                <div>
                    <div v-for="(message, index) in messages" :key="index" :class="{'forum-message received': message.user_id != user_id, 'forum-message sent': message.user_id == user_id}">
                        <strong>{{  message.user_id == user_id ? "You" : message.name }}</strong>
                        <p>{{ message.message }}</p>
                      </div>
                </div>
              </div>
              <div class="forum-footer">
                <input v-model="newMessage" type="text" class="form-control" placeholder="Write a reply...">
                <button @click="sendMessage" class="btn btn-primary">Post</button>
              </div>
            </div>
          </div>
    </div>
    
  </template>
  
  <script>
import axios from 'axios';

  export default {
    props : ['user_id'],
    data() {
      return {
        messages: [],
        newMessage: ""
      };
    },
    methods: {
        fetchMessages(){
            axios.get('/web_messsage/fetch').then(response => {
                this.messages = response.data.messages;
            }).catch(error => {
                this.errors =  error.response.data.message;
            });
        },

        sendMessage() {
            axios.post('/web_messsage/send', {
                message : this.newMessage,
            }).then(response => {
                this.fetchMessages();
                this.newMessage = '';
            }).catch(error => {
                this.errors =  error.response.data.message;
            });
        }
    },
    mounted(){
        this.fetchMessages();
        setInterval(this.fetchMessages, 1500);
    }
  };
  </script>
  
  <style scoped>
  .forum-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
    margin: auto;
    border: 1px solid #ddd;
    border-radius: 15px;
    background: white;
  }
  
  /* Right Discussion Thread */
  .forum-box {
    width: 100%;
    display: flex;
    flex-direction: column;
  }
  
  .forum-header {
    padding: 15px;
    background: #f29f05;
    color: white;
    font-weight: bold;
    border-top-right-radius: 15px;
    border-top-left-radius: 15px;
    text-align: center;
  }
  
  .forum-body {
    height: 75vh;
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f8f9fa;
  }
  
  .forum-message {
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    max-width: 100%;
  }
  
  .received {
    background: #e9ecef;
    align-self: flex-start;
  }
  
  .sent {
    background: #f29f05;
    color: white;
    align-self: flex-end;
    text-align: right;
  }
  
  .forum-footer {
    height: 70px;
    display: flex;
    padding: 10px;
    background: white;
    border-top: 1px solid #ddd;
    border-bottom-right-radius: 15px;
    border-bottom-left-radius: 15px;
  }
  
  .forum-footer input {
    flex: 1;
    margin-right: 10px;
    height: auto;
    
  }


  @media (max-width: 768px) { 
    
    .forum-container {
  
      width: 100%;
   
    }
  }
  </style>
  