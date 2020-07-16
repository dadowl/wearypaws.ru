/* ProgressBarManager v1.0 by NC22 */

function ProgressBarManager(className,static_text) {
if (className == null) className = 'progressbar_meter'; 
if (static_text == null) static_text = false; 

var PBars = []

var tmpBars = getDivsByClass(className)			    
for (i=0; i<=tmpBars.length-1; ++i) PBars[i] = {bar : tmpBars[i], static_text: static_text, animate : null, render : null}
delete tmpBars

	function parseIntZero(value) {
	value = parseInt(value)

	if (isNaN(value)) return 0
	else return value
	}
	
	function getDivsByClass(className) {
	var divList   = document.getElementsByTagName('DIV')
	var foundList = []

	for (i=0; i<=divList.length-1; ++i) 
		if (divList[i].className == className) foundList[foundList.length] = divList[i]
		
	return foundList
	}
	
	function AnimateBar(pid,newValue) {

	if (newValue == null) { 

	newValue = parseIntZero(PBars[pid].bar.style.width)
	PBars[pid].bar.style.width = '0%';

	}

	PBars[pid].bar.style.width = (parseIntZero(PBars[pid].bar.style.width) + 2) + '%';
	if (!PBars[pid].static_text) PBars[pid].bar.innerHTML = PBars[pid].bar.style.width;

	if (parseIntZero(PBars[pid].bar.style.width) < newValue) setTimeout(function(){AnimateBar(pid,newValue)},35)

	}
	
	function MoveImage(pid) {
	var cur_x = parseIntZero(PBars[pid].bar.style.backgroundPosition)
	if (cur_x > 1000) cur_x = 1

	PBars[pid].bar.style.backgroundPosition = (cur_x + 1) + 'px'

	setTimeout(function(){MoveImage(pid)},35)
	}
	
return {
			Live: function() {
				for (i=0; i<=tmpBars.length-1; ++i) {
					AnimateBar(i)
					MoveImage(i)
				}
			},			
			SetStaticText: function(id,value) { 
				if (value == null) value = true
				for (i=0; i<=PBars.length-1; ++i) if (PBars[i].bar.id == id) PBars[i].static_text = value
			}
		}
}







