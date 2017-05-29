$(document).ready( function(){
	var i = 0, limit = 3, aleaNb = 0, step = 1, key = 0, aleaPosition = ["335px", "235px", "135px", "35px"];
	var etape = 0;
	var aleaAff;
	$(".alea_btn").attr('data-content', "1");
	$(".alea_btn").on("click", aleaClick);
	$("#container_buttons").append("<div id='container_numbers' class='sort_step1'></div>");
	
	function aleaClick() {
		i = 0;
		var number = Math.floor(Math.random() * 50);
		aleaAff = setInterval( function() {aleaDisplay(number) } , 2);
		$(".alea_btn").off("click");
	};
	
	function aleaDisplay(number){ 
		if (i > number) {
			aleaStop();
			return;
		}
		$("#alea_nb").text(i); 
		i++;
	}
	
	function aleaStop(){ 
		clearInterval(aleaAff); 
		$(".alea_nb").clone().appendTo("#container_numbers").addClass("number"+aleaNb).removeClass("alea_nb").css("top", "-67px");
		if (aleaNb == limit) {
			$(".number"+aleaNb).animate({top:aleaPosition[aleaNb]}, 500, function () {
				tirageEnd();
			});
			return;
		}
		$(".number"+aleaNb).animate({top:aleaPosition[aleaNb]}, 500 , function () {
			aleaNb++;
			$(".alea_btn").attr('data-content', aleaNb+1);
			$("#alea_nb").text(""); 
			$(".alea_btn").on("click", aleaClick);
		});
	}
	
	function tirageEnd () {
		$(".alea_btn").fadeOut(1000);
		$(".alea_nb").fadeOut(1000);
		$("#initTab").fadeOut(1000);
		
		$("#container_numbers").animate({"margin-top":0}, 1000, function () {
			cn = $(this);
			$("#container_buttons").animate({"height":"410px", backgroundPosition:"0 -95px"}, 1000, function () {
				cn.append("<div id='container_buttons' class='step_container' style='display:none'><a id='step1' class='alea_btn step_btn' href='#'>Step</a></div>");
				$(".step_container").fadeIn(1000);
				sortStep(step);
			});
		});
		i=0;
	}
	
	function sortStep(step) {
		$(".alea_btn").attr('data-content', step);
		$(".step_btn").on("click", stepClick);
	}
	
	function stepClick () {
		var txt = "", keyNext = key +1;
		val1 = $(".sort_step"+step+" .number"+key).text();
		val2 = $(".sort_step"+step+" .number"+keyNext).text();
		if (key <= limit - step)
			processSort(key, val1, val2);
		else {
			$(".step_btn").off("click");
			createExpli();
			if (step < limit)
				nextStep();
			else {
				alert("Bravo ! Le tri est terminé.");
				presentation();
			}
			return;
		}
		key++;
	}
	
	function nextStep () {
		lastItem = limit - step + 1;
		prevStep = step;
		w = 250 + (step * 270);
		step++;
		key = 0;
		wp = w + "px";
		cn = $("#container_numbers:last-child").clone().removeClass("sort_step"+prevStep).addClass("sort_step"+step).fadeIn();
		$(".sort_step"+step+" .step_container"+lastItem).css("display","none");
		$("#container_buttons:first-child").append(cn).animate({"width":wp}, 1000);
		$(".sort_step"+step+" input").remove();
		$(".sort_step"+step+" .test_label").remove();
		$(".sort_step"+step+" .number"+lastItem).addClass("sort_done");
		$(".sort_step"+step+" .alea_btn").attr('data-content', step);
		$(".sort_step"+step+" .step_container"+lastItem).fadeIn(1000);
		$(".sort_step"+step+" .step_btn").on("click", stepClick);
	}
	
	function processSort(key, val1, val2) {
		keyDisplay = key + 1;
		topPos = (limit-key)*100;
		topInfo = topPos + "px";
		txt = val1+' > '+val2+' ?';
		$(".sort_step"+step).append("<label  id='test"+key+"' class='test_label'>"+keyDisplay+".</label> <input id='test"+key+"' class='test_info' value='"+txt+"' readonly />");
		$(".sort_step"+step+" #test"+key).css("top", topInfo).fadeIn(1000);
		$('#ask_add_message').empty().append(txt);
		$('#ask_add_message').dialog( "open" );
	}
	
	function permute() {
		keyPrev = key - 1;
		topPos1 = $(".sort_step"+step+" .number"+keyPrev).css("top");
		topPos2 = $(".sort_step"+step+" .number"+key).css("top");
		$(".sort_step"+step+" .number"+keyPrev).animate({top:topPos2}, 500)
		$(".sort_step"+step+" .number"+key).animate({top:topPos1}, 500, function () {
			$(".sort_step"+step+" .number"+keyPrev).removeClass("number"+keyPrev).addClass("number"+key);
			$(this).removeClass("number"+key).addClass("number"+keyPrev);
		});
	}

	function createExpli() {
		divExpli = $(".stepExpli"+step).clone();
		$(".sort_step"+step).append(divExpli);
	}

	$( "#ask_add_message" ).dialog({
		autoOpen: false,
		resizable: false,
		width:450,
		modal: true,
		position: { my: "center bottom+200", of: ".step_container:last"},
		buttons: {
			"Oui": function() {
				permute();
				$( this ).dialog( "close" );
			},
			"Non": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	function presentation () {
		$("#presentation").fadeIn();
		arrow(1);
		arrow(2);
		arrow(3);
	}
	
	function arrow (etape) {
		$("#container_buttons:first-child").append("<div id='arrow' class='arrow"+etape+"'><div id='arrow-line' class='arrow-line"+etape+"'></div></div>");
		$(".arrow"+etape).hide();
	}
	
	$("#pres_next").click(function() {
		if (etape <= (limit - 1)) {
			etape++;
			$(".arrow"+etape).toggle("scale");
			activeButton();
			$("#pres_prev").show();
			if (etape == limit)
				$("#pres_next").fadeOut();
		} else {
			return;
		}
	});

	$("#pres_prev").click(function() {
		if (etape > 0) {
			$(".arrow"+etape).toggle("scale");
			$("#pres_next").show();
			if (etape == 1)
				$("#pres_prev").fadeOut();
		} else {
			return;
		}
		etape--;
		activeButton();
	});

	function activeButton() {
		$(".sort_step1 .step_btn").off();
		$(".sort_step2 .step_btn").off();
		$(".sort_step3 .step_btn").off();
		$(".sort_step"+etape+" .step_btn").on("click", stepExpli);
	}
	
	function stepExpli() {
		if (etape == 1) {
			$(".sort_step2").toggle("fade");
			$(".sort_step3").toggle("fade");
			// $("#stepExpli").toggle("fade");
			$(".sort_step1 .stepExpli1").toggle("fade");
		} else if (etape == 2) {
			$(".sort_step1").toggle("fade");
			$(".sort_step3").toggle("fade");
			// $("#stepExpli").toggle("fade");
			$(".sort_step2 .stepExpli2").toggle("fade");
			$(".arrow1").toggle("fade");
		} else if (etape == 3) {
			$(".sort_step1").toggle("fade");
			$(".sort_step2").toggle("fade");
			// $("#stepExpli").toggle("fade");
			$(".sort_step3 .stepExpli3").toggle("fade");
			$(".arrow1").toggle("fade");
			$(".arrow2").toggle("fade");
		} 
	}
})