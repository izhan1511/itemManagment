<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('home')">
        <form @submit.prevent="addNewItem" >
          <!-- Item -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Item</label>
            <div class="col-md-7">
              <input v-model="newItem" on-click='' class="form-control" type="item" name="item">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="busy">
                Add
              </v-button>
            </div>
          </div>
        </form>

        <vue-list-picker 
          :left-items="leftSideItems" 
          :right-items="rightSideItems" 
          button-class="list-btn" 
          @move-left="itemMoveLeft"
          @move-right="itemMoveRight"
          ref="vueList"
        />
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform';
import axios from 'axios'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: this.$t('home') }
  },
  data: () => ({
    newItem: null,
    item: {},
    busy:false,
    itemLists:[]
  }),
  computed:{
    leftSideItems(){
      if(!this.itemLists.length) return [];
      return this.itemLists.filter(item => item.leftSide === true)
    },
    rightSideItems(){
      if(!this.itemLists.length) return [];
       return this.itemLists.filter(item => item.leftSide !== true)
    }
  },
  methods:{
   async addNewItem(){
      // if(!this.newItem) return;
    const res = await axios.post('/api/item' , {
      item:[
        ...this.itemLists,
        {
          content:this.newItem,
          key:Date.now(),
          leftSide:true
        }
      ]
    })
    this.newItem = null
    this.fetchItems();                                  
    },
    itemMoveLeft(item){
     const index =  this.itemLists.findIndex( i => i.key === item.key);
     this.itemLists[index] = {...item , leftSide : !item.leftSide , isSelected : false};
     console.log(item)
     axios.post('/api/item' , {item : this.itemLists}).then(res => {
     })
    },
    itemMoveRight(item){
      const index =  this.itemLists.findIndex( i => i.key === item.key);
      this.itemLists[index] = {...item , leftSide : !item.leftSide , isSelected : false};
     axios.post('/api/item' , {item : this.itemLists}).then(res => {
     })
    },
    fetchItems(){
      axios.get('/api/item').then(res => {
        if(!res.data.items) return []
      return JSON.parse(res.data.items);
    }).then(data => {
      this.itemLists = data;
    }).catch(err => console.log(err))
    }
  },
  created(){
    this.fetchItems()
  },
  mounted(){
    const buttons =  this.$refs.vueList.$el.querySelectorAll('button');
    const not = ['0' , '3' , '4']
    buttons.forEach((button , index) => {
      let a = not.find(n => n == index);
      if(a == 0 || a) {
        button.style.display = "none"
      }
      if(index == 1) button.innerText = ">";
      if(index == 2) button.innerText = "<";

    })
  }
}
</script>

<style lang="scss">
.list-btn{
  background: #eee;
  border: none;
  outline: none;
  margin-bottom: 10px;
}
</style>


