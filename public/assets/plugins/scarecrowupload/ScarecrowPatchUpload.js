//分片上传
function ScarecrowPatchUpload (uploadPath, isPatch=false,onePackSize=1024*1024, rate=500, parallelNumber=5) {
    //是否分片上传
    isPatch = isPatch == undefined ? false : Boolean(isPatch);
    if (uploadPath == undefined) {
        throw new Error("ScarecrowPatchUpload obj must parameter 1:uploadPath");
    }
    this.__init__(uploadPath, isPatch, onePackSize, rate, parallelNumber);
}

ScarecrowPatchUpload.prototype={
    constructor: ScarecrowPatchUpload,
    fileObj:null,
    fileName:"",
    fileSize:0,
    uploadPath:"./",
    onePackSize:1024*1024*8,
    //分片请求时间间隔
    rate:500,
    //最高并行上传数
    parallelNumber:10,
    parallelNumberTemp:0,
    blockData:null,
    blockNum:0,
    blockNumSum:0,
    isPatch:false,
    startIndex:0,
    endIndex:0,


    formData:null,
    ajaxObj:null,
    isSend:false,
    isSendTemp:true,
    __iCnt:0,
    //上传完成回调函数
    funcUploadSuccess:function () {},
    //上传失败回调函数
    setFuncUploadError:function() {
        throw new Error(this.fileName + " 文件上传失败!");
    },
    //每个分片上传成功回调函数
    funcUploadStateChange:function () {},
    __init__:function (uploadPath, isPatch, onePackSize,rate,parallelNumber) {
        this.isPatch = isPatch;
        this.formData = new FormData();
        this.ajaxObj = new XMLHttpRequest();
        this.uploadPath = uploadPath;
        this.rate = rate;
        this.parallelNumber  = parallelNumber;
        this.parallelNumberTemp = 0;

        if (this.isPatch) {
            this.onePackSize = onePackSize;
        }
    },
    addFile:function (fileInfo) {
        if (typeof fileInfo !== "object") {
            console.error("没有找到对应的文件");
            return false;
        }
        this.fileObj = fileInfo;
        this.fileName = this.fileObj.name;
        this.fileSize = this.fileObj.size;

        if (this.isPatch) {
            this.blockNumSum = Math.ceil(this.fileSize / this.onePackSize)
        }
        this.isSend = true;
        this.isSendTemp = false;
        if (this.isPatch) {
            this.__iCnt = setInterval(()=>{
                if (this.blockNum >= this.blockNumSum) {
                    clearInterval(this.__iCnt);
                    return ;
                }
                if (this.isSendTemp && this.parallelNumberTemp<=this.parallelNumber) {
                    this.sendFile();
                }
            }, this.rate);
        }
    },
    //发送文件
    sendFile:function () {
        this.isSendTemp = false;
        if (!this.isSend) {
            console.error("请先使用addFile添加文件对象");
            return false;
        }

        if (this.isPatch) {
            if(!this.cutFile()){
                return ;
            }
        } else {
            this.blockNum = 1;
            this.blockNumSum = 1;
            this.blockData = this.fileObj;
        }

        this.clearFormData();
        this.formData.append('upfile', this.blockData);
        this.formData.append('blockNum', this.blockNum);
        this.formData.append('blockNumSum', this.blockNumSum);
        this.formData.append('fileName', this.fileName);
        this.formData.append('isPatch', this.isPatch);
        this.ajaxObj.open('POST',this.uploadPath,false);
        this.ajaxObj.onreadystatechange =  () => {
            this.parallelNumberTemp--;
            if (this.ajaxObj.status == 500 && this.isPatch) {
                clearInterval(this.__iCnt);
            }

            if (this.ajaxObj.status == 500) {
                this.setFuncUploadError.call(this, this.ajaxObj);
            }

            if (this.ajaxObj.readyState == 4 && this.ajaxObj.status == 200) {
                this.funcUploadStateChange.call(this);
                if (this.blockNum >= this.blockNumSum) {
                    this.funcUploadSuccess.call(this, this.ajaxObj.responseText);
                    this.__resetObj();
                }
                this.ajaxObj.readyState = 1;
                this.isSendTemp = true;
            }
        }
        this.parallelNumberTemp++;
        this.ajaxObj.send(this.formData);
    },
    //分割文件
    cutFile:function () {
        this.endIndex = this.startIndex + this.onePackSize;
        if (this.startIndex > this.fileSize) {
            this.startIndex = 0;
            return false;
        }
        this.blockNum += 1;
        this.blockData = this.fileObj.slice(this.startIndex, this.endIndex);
        this.startIndex = this.endIndex;
        return true;
    },
    clearFormData:function () {
        this.formData.has('file') ? this.formData.delete("file"): null;
        this.formData.has('blockNum') ? this.formData.delete("blockNum"): null;
        this.formData.has('blockNumSum') ? this.formData.delete("blockNumSum"): null;
        this.formData.has('fileName') ? this.formData.delete("fileName"): null;
        this.formData.has('isPatch') ? this.formData.delete("isPatch"): null;
    },
    setFuncUploadSuccess:function (func) {
        if (typeof func == "function") {
            this.funcUploadSuccess = func;
        } else {
            throw new Error("setFuncUploadSuccess parameter 1 must is function");
        }
    },
    setFuncUploadError:function (func) {
        if (typeof func == "function") {
            this.setFuncUploadError = func;
        } else {
            throw new Error("setFuncUploadError parameter 1 must is function");
        }
    },
    //设置上传状态改变函数
    setFuncUploadStateChange:function (func) {
        if (typeof func == "function") {
            this.funcUploadStateChange = func;
        } else {
            throw new Error("setFuncUploadStateChange parameter 1 must is function");
        }
    },
    //重置参数
    __resetObj:function () {
        this.fileObj = null;
        this.blockNumSum = 0;
        this.blockNum = 0;
        this.endIndex = 0;
        this.formData = new FormData();
    }
}
