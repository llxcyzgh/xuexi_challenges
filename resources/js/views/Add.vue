<template>
  <div class="add">
    <div>
      <label>
        json内容
        <br>
        <textarea cols="200" rows="10" v-model="text"></textarea>
      </label>
      <br>
      <button @click="onAdd">提交</button>
    </div>

  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: "Add",
    data() {
      return {
        text: ''
      }
    },
    methods: {
      async onAdd() {
        try {
          let addResponse = axios.post('/api/questions/addByJson')
          console.log(addResponse)

          if (addResponse.status === 201) {
            alert('success')
          }else{
            alert('error')
          }
        } catch (e) {
          console.log(e)
          alert('error')
        }

      },


    }

  }
</script>

<style scoped>
  * {
    margin: 0;
    padding: 0;
  }


</style>
