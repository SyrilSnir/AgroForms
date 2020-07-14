<template>
<div class="form-group">
    <div class="custom-control custom-radio">       
        <div class="form-check" v-for="stand in standElements">
            <input v-model="selectedStand" :value="stand.id" class="custom-control-input" type="radio" :id="'standChoice' + stand.id" name="stand-choice">
            <label class="custom-control-label" :for="'standChoice' + stand.id">{{stand.name}}</label>
        </div>
        <template v-for="stand in standElements">
            <section v-if="isStandSelected(stand.id)" class="stand-info" :data-num="stand.id">
                <div class="card mb-4 shadow-sm">
                    <div class="col-sm-6">
                        <img :src="stand.image_url" class="img-fluid d-block" :alt="stand.name">
                    </div>
                    <div class="card-body">
                        <p class="card-text">Изображение стенда является приблизительным, реальная конфигурация зависит от заказанной площади.</p>
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>                              
                </div>
                <div class="desc" v-html="stand.description">
                </div>
                <div class="form-group row">                 
                        <label for="inputSquare" class="col-sm-2 col-form-label">Площадь застройки</label>
                        <div class="col-sm-10">    
                            <div class="input-group mb-3">         
                            <input v-model="standSquare" type="text" class="form-control" name="inputSquare" id="inputSquare">
                            <div class="input-group-append">
                                <span class="input-group-text">м<sup>2</sup></span>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">x<span class="price">{{stand.price}}</span> USD</span>
                            </div>                         
                        </div>
                        <div>Итого: {{calculatePrice(stand.price)['fullPrice'] | formatPrice }}</div>
                    </div>
                </div>                       
            </section>
        </template>
    </div>
</div>
</template>
<script>
export default {
    name: 'stand-list',
    data() {
        return {
         //   standSquare : '',
            selectedStand: this.localSelectedStand
        }
    },
    created() {
      // this.selectedStand = +this.localSelectedStand;
       console.log(this.selectedStand);
       console.log(this.localSelectedStand);
        this.$emit('changeSelectedStand',this.selectedStand);
        this.bus.$on('update', this.update);
    },
    methods: {
        update(stand) {
            console.log('created');
            console.log(stand);
            this.selectedStand = stand;
          //  this.$forceUpdate();
        },
        calculatePrice: function(price) {
            let standSquare = !isNaN(parseInt(this.standSquare)) ? parseInt(this.standSquare) : 0;
            let fullPrice = standSquare * price;
            let result = {
                square: this.standSquare,
                fullPrice: fullPrice
            };
            this.$emit('changeSquare',result);
            return result;
        },
        isStandSelected: function(id) {
            this.$emit('changeSelectedStand',this.selectedStand);
            return id == this.selectedStand;
        }
    },
    props: [
        'standElements',
        'standSquare',
        'localSelectedStand',
        'bus'
    ]
}
</script>

<style scoped>
    .desc {
        margin: 0 0 1rem 3rem;
        color: gray;
    }
    section {
        margin: 5px;
    }
    .price {
        padding-left: .2rem;
        padding-right: .5rem;
    }
</style>
