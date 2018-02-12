<template>
  <div class="decisionSpecificFields columns">
    <div class="column is-one-quarter">
      <normative-type></normative-type>
    </div>
    <div class="column">
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
