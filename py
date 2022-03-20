
1、安装依赖包：
yum install libffi-devel -y
yum install make gcc gcc-c++
2、下载新版本Python：
wget https://www.python.org/ftp/python/3.8.6/Python-3.8.6.tgz
3、解压：
tar -zxf Python-3.8.6.tgz
4、编译安装：
./configure --prefix=/usr/local/python3 --with-ssl
make
make install
5、建立软连接：
ln -sb /usr/local/python3/bin/python3.8 /usr/bin/python
6、验证版本：
[root@k8s-m bin]# python -V
Python 3.8.0a1
[root@k8s-m bin]# python2 -V
Python 2.7.5

报错：

ln -s /usr/local/python3Dir/bin/pip3 /usr/bin/pip
我执行make install 时遇到下列报错：
modulenotfounderror no module named ‘_ctypes’ make *** install error 1
解决：
yum install libffi-devel -y
再：
make install


/usr/local/python3/bin/pip3 install requests