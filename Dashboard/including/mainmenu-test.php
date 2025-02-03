<div>
	<div class="body2">
      <div class="div2" style="--i:5;">ASDFGH</div>
      <div class="div2" style="--i:4;">ASDFGH</div>
      <div class="div2" style="--i:3;">ASDFGH</div>
      <div class="div2" style="--i:2;">ASDFGH</div>
      <div class="div2" style="--i:1;">ASDFGH</div>
    </div>
<style>
	/* https://www.youtube.com/watch?v=MmdKeypSxE8 */
.body2 {
  display: grid;
  place-content: center;
  background: #434750;
  height: 180px;
}

.body2 > .div2 {
  position: relative;
}

.div2 {
  background: #ccc061;
  width: 180px;
  height: 70px;
  color: #FFF;
  padding: 20px;
  transform: skewY(-15deg);
  transition: 0.5s;
  cursor: pointer;
  z-index: var(--i);
}

.div2:hover {
  background: #33a3ee;
  color: white;
  transform: translate(-50px, 14px) skewY(-15deg);
}

.div2::before {
  content: '';
  position: absolute;
  height: 100%;
  top: 0;
  left: -40px;
  width: 40px;
  background: #ccc061;
  transform-origin: right;
  transform: skewY(45deg);
}
.div2:hover::before {
  background: #1f5378;
}

.div2::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 40px;
  top: -40px;
  left: 0;
  background: #ccc061;
  transform: skewX(45deg);
  transform-origin: bottom;
}
.div2:hover::after {
  background: #2982b9;
}
/* https://www.youtube.com/watch?v=MmdKeypSxE8 */
.body2 {
  /* display: grid; */
  display: flex;
  place-content: center;
  background: #FFF;
  height: 180px;
  padding-top: 63px;
  /* background: #434750; */
}

.body2 > .div2 {
  position: relative;
}

.div2 {
  background: #3e3f46;
  width: 200px;
  color: #999;
  padding: 20px;
  transform: skewY(-15deg);
  transition: 0.5s;
  cursor: pointer;
  /* z-index: var(--i); */
}

.div2:hover {
  background: #33a3ee;
  color: white;
  transform: translate(-50px, 14px) skewY(-15deg);
 
  z-index: 5 !important;
}

.div2::before {
  content: '';
  position: absolute;
  height: 100%;
  top: 0;
  left: -40px;
  width: 40px;
  background: #2e3133;
  transform-origin: right;
  transform: skewY(45deg);
}
.div2:hover::before {
  background: #1f5378;
}

.div2::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 40px;
  top: -40px;
  left: 0;
  background: #35383e;
  transform: skewX(45deg);
  transform-origin: bottom;
}
.div2:hover::after {
  background: #2982b9;
}


</style>