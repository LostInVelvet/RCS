var cdModal = document.getElementById('CdModal');
var clearModal = document.getElementById('clearModal');
var finishModal = document.getElementById('finishModal');

var cdBtn = document.getElementById('cdBtn');
var clearBtn = document.getElementById("clearBtn");
var finishBtn = document.getElementById("finishBtn");
var cropBtn = document.getElementById('cropBtn');

cdBtn.onclick = function() {
    cdModal.style.display = "block";
};
clearBtn.onclick = function() {
    clearModal.style.display = "block";
}
cropBtn.onclick = function() {
    cropModal.style.display = "block";
}
finishBtn.onclick = function() {
    finishModal.style.display = "block";
}

$('.close').click(function(){
    $('.modal').hide();
    $('.modalNoClickout').hide();
});


$('.closeDesigner').click(function(){
    $('#CdModal').hide();
});


$('#close-all').click(function(){
    $('.modal').hide();
    $('.modalNoClickout').hide();
	$('#CdModal').hide();
});

$('#close-clipart').click(function(){
    $('#clipartModal').hide();
});

window.onclick = function(event) {
	if($(event.target.id) === 'finishConfirmModal'){
		$('.modal').hide();
		$('#CdModal').hide();
	}
    else if($(event.target).hasClass('modal')){
        $('.modal').hide();
    }
}