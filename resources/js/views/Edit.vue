<template>
  <div class="index">
    <div class="loading" v-if="isLoading">
      Loading ...
    </div>

    <div>
      <button @click="onSaveDatabase">保存数据库json到文件</button>
    </div>

    <ul>
      <li>
        <ul>
          <li class="li_is_verified">Id</li>
          <li>Question</li>
          <li class="li_provenance">Provenance</li>
          <li class="li_options">Options</li>
          <li class="li_answer">Answer</li>
          <li class="li_is_verified">Is_verified</li>
          <li class="li_update">确认修改</li>
          <li class="li_delete">删除</li>
        </ul>
      </li>

      <li v-for="(item, index) in list">
        <ul>
          <li class="li_is_verified">{{ item.id ? item.id : index + 1 }}</li>
          <li><textarea name="" id="" cols="50" rows="5" v-model="item.question"></textarea></li>
          <li class="li_provenance">{{ item.provenance }}</li>
          <li class="li_options" v-html="item.options"></li>
          <li class="li_answer"><input type="text" v-model="item.answer" width="30px" height="10px"></li>
          <li class="li_is_verified">
            <select v-model="item.is_verified">
              <option value="0" selected="item.is_verified === 0 ? true : false">否</option>
              <option value="1" selected="item.is_verified === 1 ? true : false">是</option>
            </select>
          </li>
          <li class="li_update">
            <button @click="onUpdate(index)">confirm</button>
          </li>
          <li class="li_delete">
            <button @click="onDelete(index)">delete</button>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: "Index",
    data() {
      return {
        isLoading: false,
        list: null,
        error: null,
        keyword: '',
        timeOut: null
      }
    },
    created() {
      this.fetchData()
    },
    methods: {
      fetchData() {
        this.error = this.list = null
        this.isLoading = true
        axios
          .get('/api/questions?page=all')
          .then(response => {
            this.list = response.data
            this.isLoading = false
          })
      },

      async onUpdate(index) {
        let data = {
          question: this.list[index]['question'],
          answer: this.list[index]['answer'],
          is_verified: this.list[index]['is_verified']
        }

        try {
          let updateResponse = await axios.put('/api/questions/' + this.list[index]['id'], data)
          if (updateResponse.status === 204) {
            this.fetchData()
          }
        } catch (e) {
          console.log(e)
        }
      },

      async onDelete(index) {
        let id = this.list[index]['id']
        if (!window.confirm('确定删除编号为 ' + id + ' 的记录?')) {
          return false
        }

        try {
          let deleteResponse = await axios.delete('/api/questions/' + id)
          if (deleteResponse.status === 204) {
            this.fetchData()
          }
        } catch (e) {
          console.log(e)
        }
      },

      async onSaveDatabase() {
        try {
          let response = await axios.post('/api/questions/save')
          if (response.status === 201) {
            alert('保存成功')
          } else {
            alert('保存失败')
          }
        } catch (e) {
          console.log(e)
        }
      }


    }

  }
</script>

<style scoped>
  * {
    margin: 0;
    padding: 0;
  }

  .search {
    width: 300px;
    margin: 0 auto;
  }

  .input_search {
    height: 30px;
    border-radius: 10px;
    padding: 0 10px;
    border: 1px solid #bbb;
  }

  ul {
    list-style: none;
  }

  ul li ul {
    border-bottom: 1px solid #ccc;
    /*background-color: #0f0;*/
    /*overflow: hidden;*/
    display: flex;
    align-items: center;
    /*display: table-cell;*/
    /*vertical-align: middle;*/
  }

  ul li ul li {
    width: 500px;
    /*border-right: 1px solid #ccc;*/
    padding: 10px;
    /*border-bottom: 1px solid #ccc;*/
    margin-bottom: 10px;
  }

  ul li ul li:last-child {
    border-right: none;
  }

  .li_provenance {
    width: 100px;
    font-size: 10px;
  }

  .li_options {
    width: 300px;
  }

  .li_answer {
    width: 200px;
  }

  .li_is_verified {
    width: 60px;
  }

  .li_update {
    width: 100px;
  }

  .li_delete {
    width: 60px;
  }
</style>
