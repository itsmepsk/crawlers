y = $('table.data td.nobr textarea.botmarg5px.feedbacktextarea');
for(i=0;i<y.length;i++) {
	if(y[i].nextSibling.nextSibling.className === "qrateContainer feedback loggedCondition") {
		audioRating  = y[i].nextSibling.nextSibling.childNodes[3].childNodes[0].data;
		audioRating = parseInt(audioRating);
		videoRating  = y[i].nextSibling.nextSibling.childNodes[7].childNodes[0].data; 
		videoRating = parseInt(videoRating);
		if (audioRating !== 0 && videoRating !== 0) {
			y[i].nextSibling.nextSibling.childNodes[1].childNodes[3].value = audioRating;
			y[i].innerHTML = "Thank You!";
			y[i].nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.childNodes[0].click();
			y[i].parentNode.parentNode.childNodes[3].childNodes[1].click();
		}
		else {
			y[i].parentNode.parentNode.childNodes[3].childNodes[1].click();
		}
		
	}
	if (y[i].nextSibling.nextSibling.className === "buttonsline floatleft") {
		y[i].innerHTML = "Thank You!";
		y[i].nextSibling.nextSibling.childNodes[0].click();
		y[i].parentNode.parentNode.childNodes[3].childNodes[1].click();
	}
	
}
