<template>
	<div class="flex flex-col -mx-6" v-if="fields.length">
	  <span class="bg-20 py-4 px-6 flex w-full">{{ field.name }}</span> 
	  <div class="px-6">
	  	<component
	      v-for="(field, index) in fields"
	      :key="index"
	      :is="resolveComponentName(field)" 
        :resource-name="resourceName"
        :resource-id="resourceId"
        :resource="resource"
        :field="field"
        @actionExecuted="actionExecuted"
	      class="px-6" 
	      :class="{'remove-bottom-border': index == fields.length - 1}"
	    />  
	  </div>
	</div>
</template>

<script>
import { BehavesAsPanel } from 'laravel-nova'
import ResolvesFields from './ResolvesFields.vue'

export default {
  mixins: [BehavesAsPanel, ResolvesFields],

  props: ['resource', 'resourceName', 'resourceId', 'field'], 
}
</script>
