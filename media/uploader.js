
window.onload = function() {
	progression = 0;
	AllfilesSize = 0;
	last = 0;
	filesToUpload = new Array();
	fileCounter = 0;
	prs = new Array();
	uprogs = new Array();
	xs = new Array();
	mailnotvalid = false;
	isIE = false;
	sessionid = 0;
	forbidden = new Array("php","vb","asp","exe","com","cmd","ws","sc","js","lnk","ini");
	var container = document.getElementById('uploader_div'),
		fileinput = document.getElementById('fileupload'),
		names_div = document.getElementById('filenames'),
		feedback = document.getElementById('feedback'),
		progressBar = feedback.getElementsByTagName('div')[0],
		msg = feedback.getElementsByTagName('p')[0],
		username = document.getElementById('s_name'),
		phone = document.getElementById('s_phone'),
		mail = document.getElementById('s_mail'),
		show = document.getElementById('showfiles'),
		sum = document.getElementById('sum'),
		user__name=document.getElementById('user__name'),
		removeAll = document.getElementById('removefiles');
	fileinput.addEventListener('change', putfiles,false);
	
	
	var submit = document.getElementById('submit');
	
	submit.addEventListener('click',function submitfiles() {
		if(submit.getAttribute('name')=='start') {
			msg.innerHTML='';
			success_feedback.style.display = 'none';
			if(username.value.length<2) {
				username.style.background='#FFDBBD';
				showMsg('אנא הזן שם','#A33');
				alert('אנא הזן שם');
				return; 
			}
			if(phone.value.length<5) {
				phone.style.background='#FFDBBD';
				showMsg('אנא הזן מספר טלפון','#A33');
				alert('אנא הזן מספר טלפון');
				return; 
			}
			if(mailnotvalid || mail.value.length==0) { 
				mail.style.background='#FFDBBD';
				showMsg('אנא הזן כתובת מייל','#A33');
				alert('אנא הזן כתובת מייל');
				return; 
			}
			if(fileCounter==0) { showMsg('לא נבחרו קבצים להעלאה','#A33'); return; }
			vc = checkext();
			if(vc.length>0) {
				for(var i = 0; i<vc.length; i++) {
					document.getElementById('filename'+vc[i]).style.background='#F59C76';
				}
				alert("חלק מהקבצים זוהו כאסורים להעלאה, אנא הסר אותם ונסה לעלות שוב");
				return;
			}
			removeAll.disabled = true;
			fileinput.disabled = true;
			show.removeEventListener('drop',drop,false);
			show.removeEventListener('dragover',dragover,false);
			show.removeEventListener('dragleave',dragleave,false);
			for(var i = 0; i< xs.length; i++) {
				xs[i].removeEventListener('click',xclick,false);
				xs[i].style.background = '#1E6FA6';
			}
			show.scrollTop = 0;
			submit.style.background = '#EB5C1E';
			submit.style.color = '#FFF';
			submit.innerHTML = 'בטל העלאה';
			submit.setAttribute('name','abort');
			show.addEventListener('drop',drop,false);
			show.addEventListener('dragover',dragover,false);
			show.addEventListener('dragleave',dragleave,false);
			sessionid = str_shuffle(new Date().getTime());
			loadFile(0);
		}
		else if(submit.getAttribute('name')=='abort') {
			xhr.abort();
			progression = 0;
			submit.style.background = '#33DB2A';
			submit.innerHTML = 'החל העלאה';
			submit.setAttribute('name','start');
			progressBar.style.width = '0px';
			showMsg('העלאה הופסקה','#D12121');
			fileinput.disabled = false;
			removeAll.disabled = false;
			showFileList();
		}
	},false);
	
	function loadFile(fileindex) {
		if(fileCounter==0 && xhr) { xhr.abort(); return; }
		var files = filesToUpload;
		var fd = new FormData();
		fd.append("file[]",files[fileindex]);
		xhr = createXMLHttpRequest();
		xhr.upload.addEventListener('loadstart', function(e) {
			last = 0;
			if(xs[fileindex]) xs[fileindex].style.background = 'green url("assets/images/icons/downloading.gif") no-repeat';
		});
		xhr.upload.addEventListener('progress', function(e) {
			if(e.lengthComputable) {
				var ratio = e.loaded/e.total;
				var id = 'prog'+fileindex;
				if(typeof prs[fileindex]!='undefined') {
					prs[fileindex].style.width=Math.round(ratio*430)+'px';
					prs[fileindex].innerHTML = Math.round(ratio*1000)/10+'%';
				}
				if(typeof uprogs[fileindex]!='undefined') {
					uprogs[fileindex].style.height=Math.round(ratio*45)+'px';
				}
				var delta = e.loaded-last;
				progression += delta;
				var AllRatio = progression/AllfilesSize;
				if(AllRatio>1) AllRatio = 1;
				msg.style.color = '#000';
				msg.innerHTML = document.title = Math.round(AllRatio*1000)/10+'%';
				progressBar.style.width = Math.round(AllRatio*170)+'px';
				last = e.loaded;
			}
		});
		xhr.addEventListener('readystatechange', function (e) {
			if(xhr.readyState == 4 && xhr.status == 200) { 
				r = xhr.responseText.split('[END]')[0];
				errors = r.split('[ERR]');
				$.each(errors,function(i,err) {
					if(err.indexOf('failed')!=-1) {
						console.log("Can't save file");
						console.log(err.substring(5));
					}
					else {
						switch(err) {
							case 'forbidden':
								console.log('File extension is not allowed');
								break;
							case 'mysql_err':
								console.log('Connection to database has failed');
								break;
							default:
							console.log("%s - %s","Undefined error",err);
						}
					}
				});
				console.log("%s:\n%s","complete response",r);
				if(fileindex==fileCounter) return;
				if(typeof prs[fileindex]!='undefined') {
					prs[fileindex].style.width='430px';
					prs[fileindex].innerHTML = '100%';
				}
				if(typeof uprogs[fileindex]!='undefined') {
					uprogs[fileindex].style.height='45px';
				}
				msg.innerHTML = document.title = '100	%';
				xs[fileindex].style.background = 'lightgreen url("assets/images/icons/v1.jpg") no-repeat';
				if(fileindex>3) show.scrollTop +=45;
				loadFile(fileindex+1);
			}
		});
		
		
		if(fileindex==fileCounter) {
			progression = 0;
			AllfilesSize = 0;
			last = 0;
			filesToUpload = new Array();
			fileCounter = 0;
			prs = new Array();
			xs = new Array();
			progressBar.style.width='0px';
			showMsg('הקבצים הועלו בהצלחה','#AA3');
			var success_name = document.getElementById('success_name');
			var success_mail = document.getElementById('success_mail');
			success_name.innerHTML = 'שלום '+username.value;
			success_mail.innerHTML = 'מייל נשלח לכתובת '+mail.value+ ' עם אישור השליחה';
			$('#success_feedback').fadeIn('slow');
			fileinput.disabled = false;
			submit.innerHTML = 'החל העלאה';
			submit.style.background = '#33DB2A';
			submit.setAttribute('name','start');
			removeAll.disabled = false;
			show.addEventListener('drop',drop,false);
			show.addEventListener('dragover',dragover,false);
			show.addEventListener('dragleave',dragleave,false);
			
		} else {
			var params = 'un='+username.value+'&phone='+phone.value+
						'&mail='+mail.value+'&username='+user__name.value+
						'&last='+((fileindex==fileCounter-1)?'true':'false')+
						'&sessionid='+sessionid;
			xhr.open("POST","uploader.php?"+params,true);
			xhr.setRequestHeader('Cache-Control','no-cache');
			xhr.send(fd);
		}
	}
	function showMsg(txt,color) {
		msg.style.color = color;
		msg.innerHTML = txt;
	}
	removeAll.onclick = function() {
		fileinput.value = "";
		while(names_div.firstChild) {
			names_div.removeChild(names_div.firstChild);
			filesToUpload = new Array();
			fileCounter = 0;
			msg.innerHTML='';
			sum.innerHTML='';
			AllfilesSize = 0;
			progression = 0;
		}
	}
	function showFileList() {
		while(names_div.firstChild) {
			names_div.removeChild(names_div.firstChild);
		}
		prs = new Array();
		uprogs = new Array();
		xs = new Array();
		for(var i = 0; i<fileCounter;i++) {
			var file_name = document.getElementById('filename').cloneNode(true),
				uprog = file_name.getElementsByTagName('div')[0],
				details = file_name.getElementsByTagName('div')[2],
				pr = details.getElementsByTagName('div')[0],
				fname = details.getElementsByTagName('p')[0],
				fsize = file_name.getElementsByTagName('p')[1],
				rightimg = file_name.getElementsByTagName('div')[1];
			file_name.setAttribute('name',('f'+i));
			file_name.setAttribute('title',filesToUpload[i].name);
			file_name.setAttribute('id',(file_name.id+i)+'');
			prs.push(pr);
			uprogs.push(uprog);
			fname.innerHTML = filesToUpload[i].name;
			fsize.innerHTML = bytesToSize(filesToUpload[i].size);
			names_div.appendChild(file_name);
			rightimg.addEventListener('click',xclick,false);
			xs.push(rightimg);
			file_name.style.display = 'block';
		}
		
	}
	function xclick(e) {
		var ind = this.parentNode.getAttribute('name');
		ind = ind.slice(ind.indexOf('f')+1,ind.length);
		var id = this.parentNode.id;
		$('#'+id).fadeOut('fast',function() {
			names_div.removeChild(this);
			AllfilesSize-=filesToUpload[ind].size;
			filesToUpload.splice(ind,1);
			fileCounter--;
			if(fileCounter>0) {
				sum.innerHTML = 'סה"כ גודל: '+bytesToSize(AllfilesSize);
				showMsg(' סה"כ קבצים: '+fileCounter,'#000');
			}
			else {
				sum.innerHTML = '';
				msg.innerHTML = '';
			}
			showFileList();
		});
	}
	function bytesToSize(bytes) {
		var sizes = ['בתים', 'ק"ב', 'מ"ב', 'ג"ב', 'ט"ב'];
		if (bytes == 0) return 'n/a';
		var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	}
	show.addEventListener('drop',drop,false);
	show.addEventListener('dragover',dragover,false);
	show.addEventListener('dragleave',dragleave,false);
	function drop(e) {
		putfiles(e);
	}
	
	function dragover(e) {
		show.style.background = '#FDFFD6';
	}
	
	function dragleave(e) {
		show.style.background = '#FFF';
	}
	function putfiles(e) {
		e.preventDefault();
		show.style.background = '#FFF';
		var files = "";
		if(e.dataTransfer) {
			files =  e.dataTransfer.files;
		}
		else if(this.files) {
			files =  this.files;
		}
		else  {//ie
			isIE = true;
            filesToUpload.push(fileinput.value);
			console.log(fileinput.value);
			
		}
		if(typeof files == 'undefined') return;
		var flag1 = false;
		for(var i = 0; i <files.length; i++) {
			for(var j = 0; j<filesToUpload.length;j++) {
				if(filesToUpload[j].name==files[i].name) flag1 = true;
			}
			if(!flag1) {
				AllfilesSize+=files[i].size;
				filesToUpload.push(files[i]);
				fileCounter++;
			}
			flag1 = false;	
		}
		showMsg(' סה"כ קבצים: '+fileCounter,'#000');
		sum.innerHTML = 'סה"כ גודל: '+bytesToSize(AllfilesSize);
		showFileList();
		removeAll.disabled = false;
	}
	var mailerror = document.getElementById('mailerror');
	mail.onblur = function() {
		if(this.value.length==0) return;
		var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(!regex.test(this.value)) { 
			mailerror.innerHTML = 'כתובת מייל אינה תקינה';
			mailnotvalid = true;
			return false; 
		}
		else {
			mailerror.innerHTML = '';
			mailnotvalid = false;
			return true;
		}
	}
	username.onfocus = phone.onfocus = mail.onfocus = function() {
		this.style.background='#FFF';
	}
	checkext = function() {
		var rows = new Array();
		for(var i = 0; i<filesToUpload.length;i++) {
			var ext = filesToUpload[i].name.split('.');
			ext = ext[ext.length-1];
			for(var j = 0; j<forbidden.length;j++) {
				if(ext.indexOf(forbidden[j])!=-1) {
					rows.push(i);
					break;
				}
			}
		}
		return rows;
	}
}
function createXMLHttpRequest() {
	if(window.XMLHttpRequest)	var xhr = new XMLHttpRequest();
	else var xhr = new ActiveXObject("Microsoft.xhr");
	return xhr;
}
window.addEventListener('dragover',function(e) { 
e = e || window.event;
e.preventDefault();

 },false);
window.addEventListener('drop',function(e) { 
e = e || window.event;
e.preventDefault();

 },false);

function str_shuffle (str) {
  if (arguments.length === 0) {
    throw 'Wrong parameter count for str_shuffle()';
  }

  if (str == null) {
    return '';
  }

  str += '';

  var newStr = '', rand, i = str.length;

  while (i) {
    rand = Math.floor(Math.random() * i);
    newStr += str.charAt(rand);
    str = str.substring(0, rand) + str.substr(rand + 1);
    i--;
  }

  return newStr;
}
