<!--
  - ODM.Web  https://github.com/electropsycho/ODM.Web
  - Copyright 2019-2020 Hakan GÜLEN
  -
  - Licensed under the Apache License, Version 2.0 (the "License");
  - you may not use this file except in compliance with the License.
  - You may obtain a copy of the License at
  -
  - http://www.apache.org/licenses/LICENSE-2.0
  -
  - Unless required by applicable law or agreed to in writing, software
  - distributed under the License is distributed on an "AS IS" BASIS,
  - WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  - See the License for the specific language governing permissions and
  - limitations under the License.
  -->

<template>
  <div
    v-if="spin_style.rotating_plane"
    class="rotating_plane"
  />
  <div
    v-else-if="spin_style.double_bounce"
    class="double_bounce"
  >
    <div class="double-bounce1" />
    <div class="double-bounce2" />
  </div>
  <div
    v-else-if="spin_style.wave"
    class="wave"
  >
    <div class="rect1" />
    <div class="rect2" />
    <div class="rect3" />
    <div class="rect4" />
    <div class="rect5" />
  </div>
  <div
    v-else-if="spin_style.wandering_cube"
    class="wandering_cube"
  >
    <div class="cube1" />
    <div class="cube2" />
  </div>
  <div
    v-else-if="spin_style.pulse"
    class="pulse"
  />
  <div
    v-else-if="spin_style.chasing_dots"
    class="chasing_dots"
  >
    <div class="dot1" />
    <div class="dot2" />
  </div>
  <div
    v-else-if="spin_style.three_bounce"
    class="three_bounce"
  >
    <div class="bounce1" />
    <div class="bounce2" />
    <div class="bounce3" />
  </div>
  <div
    v-else-if="spin_style.circle"
    class="circle"
  >
    <div class="sk-circle1 sk-child" />
    <div class="sk-circle2 sk-child" />
    <div class="sk-circle3 sk-child" />
    <div class="sk-circle4 sk-child" />
    <div class="sk-circle5 sk-child" />
    <div class="sk-circle6 sk-child" />
    <div class="sk-circle7 sk-child" />
    <div class="sk-circle8 sk-child" />
    <div class="sk-circle9 sk-child" />
    <div class="sk-circle10 sk-child" />
    <div class="sk-circle11 sk-child" />
    <div class="sk-circle12 sk-child" />
  </div>
  <div
    v-else-if="spin_style.cube_grid"
    class="cube_grid"
  >
    <div class="sk-cube sk-cube1" />
    <div class="sk-cube sk-cube2" />
    <div class="sk-cube sk-cube3" />
    <div class="sk-cube sk-cube4" />
    <div class="sk-cube sk-cube5" />
    <div class="sk-cube sk-cube6" />
    <div class="sk-cube sk-cube7" />
    <div class="sk-cube sk-cube8" />
    <div class="sk-cube sk-cube9" />
  </div>
  <div
    v-else-if="spin_style.folding_cube"
    class="folding_cube"
  >
    <div class="sk-cube1 sk-cube" />
    <div class="sk-cube2 sk-cube" />
    <div class="sk-cube4 sk-cube" />
    <div class="sk-cube3 sk-cube" />
  </div>
  <div
    v-else-if="spin_style.fading_circle"
    class="fading_circle"
  >
    <div class="sk-circle1 sk-circle" />
    <div class="sk-circle2 sk-circle" />
    <div class="sk-circle3 sk-circle" />
    <div class="sk-circle4 sk-circle" />
    <div class="sk-circle5 sk-circle" />
    <div class="sk-circle6 sk-circle" />
    <div class="sk-circle7 sk-circle" />
    <div class="sk-circle8 sk-circle" />
    <div class="sk-circle9 sk-circle" />
    <div class="sk-circle10 sk-circle" />
    <div class="sk-circle11 sk-circle" />
    <div class="sk-circle12 sk-circle" />
  </div>
</template>

<script>
export default {
  name: 'Spinner',
  props: ['spinStyle'],
  data () {
    return {
      spin_style: {
        rotating_plane: false,
        double_bounce: false,
        wave: false,
        wandering_cube: false,
        pulse: false,
        chasing_dots: false,
        three_bounce: false,
        circle: false,
        cube_grid: false,
        folding_cube: false,
        fading_circle: false
      }
    }
  },
  created () {
    Object.keys(this.spin_style).forEach((value) => {
      this.spin_style[value] = false
    })
    this.spin_style[this.spinStyle] = true
  }
}
</script>

<style scoped>
  /*Include this in component*/
  .rotating_plane {
    width: 40px;
    height: 40px;
    background-color: #333;

    margin: 100px auto;
    -webkit-animation: sk-rotateplane 1.2s infinite ease-in-out;
    animation: sk-rotateplane 1.2s infinite ease-in-out;
  }

  @-webkit-keyframes sk-rotateplane {
    0% { -webkit-transform: perspective(120px) }
    50% { -webkit-transform: perspective(120px) rotateY(180deg) }
    100% { -webkit-transform: perspective(120px) rotateY(180deg)  rotateX(180deg) }
  }

  @keyframes sk-rotateplane {
    0% {
      transform: perspective(120px) rotateX(0deg) rotateY(0deg);
      -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg)
    } 50% {
        transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
        -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg)
      } 100% {
          transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
          -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
        }
  }

  /*Double Bounce*/
  .double_bounce {
    width: 40px;
    height: 40px;

    position: relative;
    margin: 100px auto;
  }

  .double-bounce1, .double-bounce2 {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #333;
    opacity: 0.6;
    position: absolute;
    top: 0;
    left: 0;

    -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
    animation: sk-bounce 2.0s infinite ease-in-out;
  }

  .double-bounce2 {
    -webkit-animation-delay: -1.0s;
    animation-delay: -1.0s;
  }

  @-webkit-keyframes sk-bounce {
    0%, 100% { -webkit-transform: scale(0.0) }
    50% { -webkit-transform: scale(1.0) }
  }

  @keyframes sk-bounce {
    0%, 100% {
      transform: scale(0.0);
      -webkit-transform: scale(0.0);
    } 50% {
        transform: scale(1.0);
        -webkit-transform: scale(1.0);
      }
  }

  /*Wave*/
  .wave {
    margin: 100px auto;
    width: 50px;
    height: 40px;
    text-align: center;
    font-size: 10px;
  }

  .wave > div {
    background-color: #333;
    height: 100%;
    width: 6px;
    display: inline-block;

    -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
    animation: sk-stretchdelay 1.2s infinite ease-in-out;
  }

  .wave .rect2 {
    -webkit-animation-delay: -1.1s;
    animation-delay: -1.1s;
  }

  .wave .rect3 {
    -webkit-animation-delay: -1.0s;
    animation-delay: -1.0s;
  }

  .wave .rect4 {
    -webkit-animation-delay: -0.9s;
    animation-delay: -0.9s;
  }

  .wave .rect5 {
    -webkit-animation-delay: -0.8s;
    animation-delay: -0.8s;
  }

  @-webkit-keyframes sk-stretchdelay {
    0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
    20% { -webkit-transform: scaleY(1.0) }
  }

  @keyframes sk-stretchdelay {
    0%, 40%, 100% {
      transform: scaleY(0.4);
      -webkit-transform: scaleY(0.4);
    }  20% {
         transform: scaleY(1.0);
         -webkit-transform: scaleY(1.0);
       }
  }

  /*Wandering Cube*/
  .wandering_cube{
    margin: 100px auto;
    width: 40px;
    height: 40px;
    position: relative;
  }

  .cube1, .cube2 {
    background-color: #333;
    width: 15px;
    height: 15px;
    position: absolute;
    top: 0;
    left: 0;

    -webkit-animation: sk-cubemove 1.8s infinite ease-in-out;
    animation: sk-cubemove 1.8s infinite ease-in-out;
  }

  .cube2 {
    -webkit-animation-delay: -0.9s;
    animation-delay: -0.9s;
  }

  @-webkit-keyframes sk-cubemove {
    25% { -webkit-transform: translateX(42px) rotate(-90deg) scale(0.5) }
    50% { -webkit-transform: translateX(42px) translateY(42px) rotate(-180deg) }
    75% { -webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5) }
    100% { -webkit-transform: rotate(-360deg) }
  }

  @keyframes sk-cubemove {
    25% {
      transform: translateX(42px) rotate(-90deg) scale(0.5);
      -webkit-transform: translateX(42px) rotate(-90deg) scale(0.5);
    } 50% {
        transform: translateX(42px) translateY(42px) rotate(-179deg);
        -webkit-transform: translateX(42px) translateY(42px) rotate(-179deg);
      } 50.1% {
          transform: translateX(42px) translateY(42px) rotate(-180deg);
          -webkit-transform: translateX(42px) translateY(42px) rotate(-180deg);
        } 75% {
            transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);
            -webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);
          } 100% {
              transform: rotate(-360deg);
              -webkit-transform: rotate(-360deg);
            }
  }

  /*Pulse*/
  .pulse {
    width: 40px;
    height: 40px;
    margin: 100px auto;
    background-color: #333;

    border-radius: 100%;
    -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
    animation: sk-scaleout 1.0s infinite ease-in-out;
  }

  @-webkit-keyframes sk-scaleout {
    0% { -webkit-transform: scale(0) }
    100% {
      -webkit-transform: scale(1.0);
      opacity: 0;
    }
  }

  @keyframes sk-scaleout {
    0% {
      -webkit-transform: scale(0);
      transform: scale(0);
    } 100% {
        -webkit-transform: scale(1.0);
        transform: scale(1.0);
        opacity: 0;
      }
  }

  /*Chasing Dots*/
  .chasing_dots {
    margin: 100px auto;
    width: 40px;
    height: 40px;
    position: relative;
    text-align: center;

    -webkit-animation: sk-rotate 2.0s infinite linear;
    animation: sk-rotate 2.0s infinite linear;
  }

  .dot1, .dot2 {
    width: 60%;
    height: 60%;
    display: inline-block;
    position: absolute;
    top: 0;
    background-color: #333;
    border-radius: 100%;

    -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
    animation: sk-bounce 2.0s infinite ease-in-out;
  }

  .dot2 {
    top: auto;
    bottom: 0;
    -webkit-animation-delay: -1.0s;
    animation-delay: -1.0s;
  }

  @-webkit-keyframes sk-rotate { 100% { -webkit-transform: rotate(360deg) }}
  @keyframes sk-rotate { 100% { transform: rotate(360deg); -webkit-transform: rotate(360deg) }}

  @-webkit-keyframes sk-bounce {
    0%, 100% { -webkit-transform: scale(0.0) }
    50% { -webkit-transform: scale(1.0) }
  }

  @keyframes sk-bounce {
    0%, 100% {
      transform: scale(0.0);
      -webkit-transform: scale(0.0);
    } 50% {
        transform: scale(1.0);
        -webkit-transform: scale(1.0);
      }
  }

  /*Three Bounce*/
  .three_bounce {
    margin: 100px auto 0;
    width: 70px;
    text-align: center;
  }

  .three_bounce > div {
    width: 18px;
    height: 18px;
    background-color: #333;

    border-radius: 100%;
    display: inline-block;
    -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
    animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  }

  .three_bounce .bounce1 {
    -webkit-animation-delay: -0.32s;
    animation-delay: -0.32s;
  }

  .three_bounce .bounce2 {
    -webkit-animation-delay: -0.16s;
    animation-delay: -0.16s;
  }

  @-webkit-keyframes sk-bouncedelay {
    0%, 80%, 100% { -webkit-transform: scale(0) }
    40% { -webkit-transform: scale(1.0) }
  }

  @keyframes sk-bouncedelay {
    0%, 80%, 100% {
      -webkit-transform: scale(0);
      transform: scale(0);
    } 40% {
        -webkit-transform: scale(1.0);
        transform: scale(1.0);
      }
  }

  /*Circle*/
  .circle {
    margin: 100px auto;
    width: 40px;
    height: 40px;
    position: relative;
  }
  .circle .sk-child {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
  }
  .circle .sk-child:before {
    content: '';
    display: block;
    margin: 0 auto;
    width: 15%;
    height: 15%;
    background-color: #333;
    border-radius: 100%;
    -webkit-animation: sk-circleBounceDelay 1.2s infinite ease-in-out both;
    animation: sk-circleBounceDelay 1.2s infinite ease-in-out both;
  }
  .circle .sk-circle2 {
    -webkit-transform: rotate(30deg);
    -ms-transform: rotate(30deg);
    transform: rotate(30deg); }
  .circle .sk-circle3 {
    -webkit-transform: rotate(60deg);
    -ms-transform: rotate(60deg);
    transform: rotate(60deg); }
  .circle .sk-circle4 {
    -webkit-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg); }
  .circle .sk-circle5 {
    -webkit-transform: rotate(120deg);
    -ms-transform: rotate(120deg);
    transform: rotate(120deg); }
  .circle .sk-circle6 {
    -webkit-transform: rotate(150deg);
    -ms-transform: rotate(150deg);
    transform: rotate(150deg); }
  .circle .sk-circle7 {
    -webkit-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg); }
  .circle .sk-circle8 {
    -webkit-transform: rotate(210deg);
    -ms-transform: rotate(210deg);
    transform: rotate(210deg); }
  .circle .sk-circle9 {
    -webkit-transform: rotate(240deg);
    -ms-transform: rotate(240deg);
    transform: rotate(240deg); }
  .circle .sk-circle10 {
    -webkit-transform: rotate(270deg);
    -ms-transform: rotate(270deg);
    transform: rotate(270deg); }
  .circle .sk-circle11 {
    -webkit-transform: rotate(300deg);
    -ms-transform: rotate(300deg);
    transform: rotate(300deg); }
  .circle .sk-circle12 {
    -webkit-transform: rotate(330deg);
    -ms-transform: rotate(330deg);
    transform: rotate(330deg); }
  .circle .sk-circle2:before {
    -webkit-animation-delay: -1.1s;
    animation-delay: -1.1s; }
  .circle .sk-circle3:before {
    -webkit-animation-delay: -1s;
    animation-delay: -1s; }
  .circle .sk-circle4:before {
    -webkit-animation-delay: -0.9s;
    animation-delay: -0.9s; }
  .circle .sk-circle5:before {
    -webkit-animation-delay: -0.8s;
    animation-delay: -0.8s; }
  .circle .sk-circle6:before {
    -webkit-animation-delay: -0.7s;
    animation-delay: -0.7s; }
  .circle .sk-circle7:before {
    -webkit-animation-delay: -0.6s;
    animation-delay: -0.6s; }
  .circle .sk-circle8:before {
    -webkit-animation-delay: -0.5s;
    animation-delay: -0.5s; }
  .circle .sk-circle9:before {
    -webkit-animation-delay: -0.4s;
    animation-delay: -0.4s; }
  .circle .sk-circle10:before {
    -webkit-animation-delay: -0.3s;
    animation-delay: -0.3s; }
  .circle .sk-circle11:before {
    -webkit-animation-delay: -0.2s;
    animation-delay: -0.2s; }
  .circle .sk-circle12:before {
    -webkit-animation-delay: -0.1s;
    animation-delay: -0.1s; }

  @-webkit-keyframes sk-circleBounceDelay {
    0%, 80%, 100% {
      -webkit-transform: scale(0);
      transform: scale(0);
    } 40% {
        -webkit-transform: scale(1);
        transform: scale(1);
      }
  }

  @keyframes sk-circleBounceDelay {
    0%, 80%, 100% {
      -webkit-transform: scale(0);
      transform: scale(0);
    } 40% {
        -webkit-transform: scale(1);
        transform: scale(1);
      }
  }

  /*Cube Grid*/
  .cube_grid {
    width: 40px;
    height: 40px;
    margin: 100px auto;
  }

  .cube_grid .sk-cube {
    width: 33%;
    height: 33%;
    background-color: #00a7d0;
    float: left;
    -webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
    animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
  }
  .cube_grid .sk-cube1 {
    -webkit-animation-delay: 0.2s;
    animation-delay: 0.2s; }
  .cube_grid .sk-cube2 {
    -webkit-animation-delay: 0.3s;
    animation-delay: 0.3s; }
  .cube_grid .sk-cube3 {
    -webkit-animation-delay: 0.4s;
    animation-delay: 0.4s; }
  .cube_grid .sk-cube4 {
    -webkit-animation-delay: 0.1s;
    animation-delay: 0.1s; }
  .cube_grid .sk-cube5 {
    -webkit-animation-delay: 0.2s;
    animation-delay: 0.2s; }
  .cube_grid .sk-cube6 {
    -webkit-animation-delay: 0.3s;
    animation-delay: 0.3s; }
  .cube_grid .sk-cube7 {
    -webkit-animation-delay: 0s;
    animation-delay: 0s; }
  .cube_grid .sk-cube8 {
    -webkit-animation-delay: 0.1s;
    animation-delay: 0.1s; }
  .cube_grid .sk-cube9 {
    -webkit-animation-delay: 0.2s;
    animation-delay: 0.2s; }

  @-webkit-keyframes sk-cubeGridScaleDelay {
    0%, 70%, 100% {
      -webkit-transform: scale3D(1, 1, 1);
      transform: scale3D(1, 1, 1);
    } 35% {
        -webkit-transform: scale3D(0, 0, 1);
        transform: scale3D(0, 0, 1);
      }
  }

  @keyframes sk-cubeGridScaleDelay {
    0%, 70%, 100% {
      -webkit-transform: scale3D(1, 1, 1);
      transform: scale3D(1, 1, 1);
    } 35% {
        -webkit-transform: scale3D(0, 0, 1);
        transform: scale3D(0, 0, 1);
      }
  }

  /*Folding Cube*/
  .folding_cube {
    margin: 20px auto;
    width: 40px;
    height: 40px;
    position: relative;
    -webkit-transform: rotateZ(45deg);
    transform: rotateZ(45deg);
  }

  .folding_cube .sk-cube {
    float: left;
    width: 50%;
    height: 50%;
    position: relative;
    -webkit-transform: scale(1.1);
    -ms-transform: scale(1.1);
    transform: scale(1.1);
  }
  .folding_cube .sk-cube:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #333;
    -webkit-animation: sk-foldCubeAngle 2.4s infinite linear both;
    animation: sk-foldCubeAngle 2.4s infinite linear both;
    -webkit-transform-origin: 100% 100%;
    -ms-transform-origin: 100% 100%;
    transform-origin: 100% 100%;
  }
  .folding_cube .sk-cube2 {
    -webkit-transform: scale(1.1) rotateZ(90deg);
    transform: scale(1.1) rotateZ(90deg);
  }
  .folding_cube .sk-cube3 {
    -webkit-transform: scale(1.1) rotateZ(180deg);
    transform: scale(1.1) rotateZ(180deg);
  }
  .folding-cube .sk-cube4 {
    -webkit-transform: scale(1.1) rotateZ(270deg);
    transform: scale(1.1) rotateZ(270deg);
  }
  .folding_cube .sk-cube2:before {
    -webkit-animation-delay: 0.3s;
    animation-delay: 0.3s;
  }
  .folding_cube .sk-cube3:before {
    -webkit-animation-delay: 0.6s;
    animation-delay: 0.6s;
  }
  .folding_cube .sk-cube4:before {
    -webkit-animation-delay: 0.9s;
    animation-delay: 0.9s;
  }
  @-webkit-keyframes sk-foldCubeAngle {
    0%, 10% {
      -webkit-transform: perspective(140px) rotateX(-180deg);
      transform: perspective(140px) rotateX(-180deg);
      opacity: 0;
    } 25%, 75% {
        -webkit-transform: perspective(140px) rotateX(0deg);
        transform: perspective(140px) rotateX(0deg);
        opacity: 1;
      } 90%, 100% {
          -webkit-transform: perspective(140px) rotateY(180deg);
          transform: perspective(140px) rotateY(180deg);
          opacity: 0;
        }
  }

  @keyframes sk-foldCubeAngle {
    0%, 10% {
      -webkit-transform: perspective(140px) rotateX(-180deg);
      transform: perspective(140px) rotateX(-180deg);
      opacity: 0;
    } 25%, 75% {
        -webkit-transform: perspective(140px) rotateX(0deg);
        transform: perspective(140px) rotateX(0deg);
        opacity: 1;
      } 90%, 100% {
          -webkit-transform: perspective(140px) rotateY(180deg);
          transform: perspective(140px) rotateY(180deg);
          opacity: 0;
        }
  }

  /*Fading Circle*/
  .fading_circle {
    margin: 100px auto;
    width: 40px;
    height: 40px;
    position: relative;
  }

  .fading_circle .sk-circle {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
  }

  .fading_circle .sk-circle:before {
    content: '';
    display: block;
    margin: 0 auto;
    width: 15%;
    height: 15%;
    background-color: #00a7d0;
    border-radius: 100%;
    -webkit-animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
    animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
  }
  .fading_circle .sk-circle2 {
    -webkit-transform: rotate(30deg);
    -ms-transform: rotate(30deg);
    transform: rotate(30deg);
  }
  .fading_circle .sk-circle3 {
    -webkit-transform: rotate(60deg);
    -ms-transform: rotate(60deg);
    transform: rotate(60deg);
  }
  .fading_circle .sk-circle4 {
    -webkit-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg);
  }
  .fading_circle .sk-circle5 {
    -webkit-transform: rotate(120deg);
    -ms-transform: rotate(120deg);
    transform: rotate(120deg);
  }
  .fading_circle .sk-circle6 {
    -webkit-transform: rotate(150deg);
    -ms-transform: rotate(150deg);
    transform: rotate(150deg);
  }
  .fading_circle .sk-circle7 {
    -webkit-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
  }
  .fading_circle .sk-circle8 {
    -webkit-transform: rotate(210deg);
    -ms-transform: rotate(210deg);
    transform: rotate(210deg);
  }
  .fading_circle .sk-circle9 {
    -webkit-transform: rotate(240deg);
    -ms-transform: rotate(240deg);
    transform: rotate(240deg);
  }
  .fading_circle .sk-circle10 {
    -webkit-transform: rotate(270deg);
    -ms-transform: rotate(270deg);
    transform: rotate(270deg);
  }
  .fading_circle .sk-circle11 {
    -webkit-transform: rotate(300deg);
    -ms-transform: rotate(300deg);
    transform: rotate(300deg);
  }
  .fading_circle .sk-circle12 {
    -webkit-transform: rotate(330deg);
    -ms-transform: rotate(330deg);
    transform: rotate(330deg);
  }
  .fading_circle.sk-circle2:before {
    -webkit-animation-delay: -1.1s;
    animation-delay: -1.1s;
  }
  .fading_circle .sk-circle3:before {
    -webkit-animation-delay: -1s;
    animation-delay: -1s;
  }
  .fading_circle .sk-circle4:before {
    -webkit-animation-delay: -0.9s;
    animation-delay: -0.9s;
  }
  .fading_circle .sk-circle5:before {
    -webkit-animation-delay: -0.8s;
    animation-delay: -0.8s;
  }
  .fading_circle .sk-circle6:before {
    -webkit-animation-delay: -0.7s;
    animation-delay: -0.7s;
  }
  .fading_circle .sk-circle7:before {
    -webkit-animation-delay: -0.6s;
    animation-delay: -0.6s;
  }
  .fading_circle .sk-circle8:before {
    -webkit-animation-delay: -0.5s;
    animation-delay: -0.5s;
  }
  .fading_circle .sk-circle9:before {
    -webkit-animation-delay: -0.4s;
    animation-delay: -0.4s;
  }
  .fading_circle .sk-circle10:before {
    -webkit-animation-delay: -0.3s;
    animation-delay: -0.3s;
  }
  .fading_circle .sk-circle11:before {
    -webkit-animation-delay: -0.2s;
    animation-delay: -0.2s;
  }
  .fading_circle .sk-circle12:before {
    -webkit-animation-delay: -0.1s;
    animation-delay: -0.1s;
  }

  @-webkit-keyframes sk-circleFadeDelay {
    0%, 39%, 100% { opacity: 0; }
    40% { opacity: 1; }
  }

  @keyframes sk-circleFadeDelay {
    0%, 39%, 100% { opacity: 0; }
    40% { opacity: 1; }
  }
</style>
