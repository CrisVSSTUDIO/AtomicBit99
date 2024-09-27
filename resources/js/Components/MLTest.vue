<template>
  <!-- based on  https://codepen.io/jasonmayes/pen/qBEJxgg -->
  <component is="style">



    .classifyOnClick {
    position: relative;
    float: left;
    margin: 2% 1%;
    cursor: pointer;
    }

    .classifyOnClick p {
    position: absolute;
    padding: 5px;
    background-color: rgba(255, 111, 0, 0.85);
    color: #FFF;
    border: 1px dashed rgba(255, 255, 255, 0.7);
    z-index: 2;
    font-size: 12px;
    margin: 0;
    }

    .highlighter {
    background: rgba(0, 255, 0, 0.25);
    border: 1px dashed #fff;
    z-index: 1;
    position: absolute;
    }

    .classifyOnClick {
    z-index: 0;
    }

  </component>
  <div id="app">
    <div v-if="!showBtn" class="my-5">
      <div class="spinner-border spinner-border-sm" role="status"></div>
      <span class=""> Loading...</span>
    </div>
    <section class="py-16" ref="demosSection" v-if="showBtn">
      <div class="w-screen mx-auto px-4 md:px-8">

        <ul class=" grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <li v-for="file in imgFiles" :key="file.id" class="classifyOnClick">
            <div class="flex items-start justify-between p-4">
              <div class="space-y-2">
                <img :src="'http://127.0.0.1:8000/storage/' + file.upload" @click="handleClick" class="shadow-md" />

              </div>

            </div>

          </li>
        </ul>
      </div>
    </section>
  </div>
</template>
<script setup>

//I should be able to pass laravel php controller data to a blade view, and then pass it to the vue js component
import { ref } from 'vue'

import * as cocoSsd from '@tensorflow-models/coco-ssd'
import '@tensorflow/tfjs-backend-webgl';
import '@tensorflow/tfjs-backend-cpu';
var model = undefined;
const demosSection = ref(null)// Before we can use COCO-SSD class we must wait for it to finish
const showBtn = ref(false)
const props = defineProps({
  imgFiles: Array
})
// loading. Machine Learning models can be large and take a moment to
// get everything needed to run.
cocoSsd.load().then(function (loadedModel) {
  model = loadedModel;
  showBtn.value = true
});

// When an image is clicked, let's classify it and display results!
async function handleClick(event) {
  if (!model) {
    console.log('Wait for model to load before clicking!');
    return;
  }

  model.detect(event.target).then(function (predictions) {

    for (let n = 0; n < predictions.length; n++) {
      // Description text
      const p = document.createElement('p');
      p.innerText = predictions[n].class + ' - with '
        + Math.round(parseFloat(predictions[n].score) * 100)
        + '% confidence.';

      p.style = 'left: ' + predictions[n].bbox[0] + 'px;' +
        'top: ' + predictions[n].bbox[1] + 'px; ' +
        'width: ' + (predictions[n].bbox[2] - 10) + 'px;';

      const highlighter = document.createElement('div');
      highlighter.setAttribute('class', 'highlighter');
      highlighter.style = 'left: ' + predictions[n].bbox[0] + 'px;' +
        'top: ' + predictions[n].bbox[1] + 'px;' +
        'width: ' + predictions[n].bbox[2] + 'px;' +
        'height: ' + predictions[n].bbox[3] + 'px;';

      event.target.parentNode.appendChild(highlighter);
      event.target.parentNode.appendChild(p);
    }
  });
}
</script>