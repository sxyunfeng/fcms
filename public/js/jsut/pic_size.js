
//  控制图片尺寸大小

var flag=false; 
function DrawImage(ImgD,a){ 
var w = a
var h = a
var image=new Image(); 
image.src=ImgD.src; 
if(image.width>0 && image.height>0){ 
flag=true; 
if(image.width/image.height>= w/h){ 
if(image.width>w){ 
ImgD.width=w; 
ImgD.height=(image.height*h)/image.width; 
}else{ 
ImgD.width=image.width; 
ImgD.height=image.height; 
} 
ImgD.alt=image.width+"×"+image.height; 
} 
else{ 
if(image.height>h){ 
ImgD.height=h; 
ImgD.width=(image.width*w)/image.height; 
}else{ 
ImgD.width=image.width; 
ImgD.height=image.height; 
} 
ImgD.alt=image.width+"×"+image.height; 
} 
} 
} 

// JavaScript Document