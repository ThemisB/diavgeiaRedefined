<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-4">
      <normative-type></normative-type>
    </div>
    <div class="col-xs-8">
      <publish-via></publish-via>
    </div>
  </div>
</template>

<script>

import PublishVia from './common-properties/PublishVia.vue'
import NormativeType from './common-properties/NormativeType.vue'

export default {
  components: {PublishVia, NormativeType}
}
</script>
