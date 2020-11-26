<template>
	<div :class="`text-${field.textAlign}`">
    <tooltip trigger="click"  v-if="fields.length > expansionOverflow">
      <div class="text-primary inline-flex items-center dim cursor-pointer">
        <span class="text-primary font-bold">{{ __('View') }}</span>
      </div> 
      <tooltip-content slot="content" class="flex flex-wrap" style="width: 60vh">
        <span 
          class="flex px-2 py-4 w-1/2 border-30" 
          v-for="(field, index) in fields"
          :class="{
            'border-r': index%2 == 0 && fields.length - index > 0, 
            'border-b': fields.length - index > 1 && fields.length > 2
          }"
        > 
          <span class="flex w-1/2">{{ field.name }}: </span>
          <component
  		      :key="index"
  		      :is="`index-${field.component}`"
  		      :resource-name="resourceName"
  		      :field="field"
  		    /> 
        </span>
      </tooltip-content>
    </tooltip>

    <div class="flex flex-col" v-else-if="fields.length"> 
      <div class="flex mt-2" v-for="(field, index) in fields"> 
        <span class="pr-2 text-80">{{ field.name }}:</span>
        <component 
          :key="index"
          :is="`index-${field.component}`"
          :resource-name="resourceName"
          :field="field"
        />  
      </div>
    </div>
    
    <span v-else>&mdash;</span>
  </div>
</template>

<script>
import ResolvesFields from './ResolvesFields.vue'

export default {
  mixins: [ResolvesFields],

	props: ['resourceName', 'field'], 

  computed: {
    expansionOverflow() {
      return this.field.expansionOverflow ? this.field.expansionOverflow : 0;
    },
  },
}
</script>
