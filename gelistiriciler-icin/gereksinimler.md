# Gereksinimler

## ODM.Web'i kendi sunucumuzda\(MEB\) kullanabilmem için en başta ne yapmam gerekiyor?

Öncelikle bağlı bulunduğunuz Milli Eğitim Müdürlüğünün Bilgi İşlem Sorumlusundan sunucuya kuracağımız yazılım için modul kaydı yapmasını istememiz gerekiyor. Bu modül kaydına ilişkin bilgliler mail ya da whatsapp yoluyla tarafınıza verilebilir.

Burada biraz daha bilgi vemenin yararlı olacağını düşünüyoruz. Geliştirdiğimiz yazılım modern web teknolojilerini\(webpack, Vue.js, Laravel 5.8 gibi\) desteklediği için modern bir PHP sürümüne ihtiyacımız olacak ayrıca aşağıda belirtilen maddeler olmazsa olmazlardan;

* PHP &gt;= 7.1.3
* BCMath PHP Eklentisi
* Ctype PHP Eklentisi
* JSON PHP Eklentisi
* Mbstring PHP Eklentisi
* OpenSSL PHP Eklentisi
* PDO PHP Eklentisi
* Tokenizer PHP Eklentisi
* XML PHP Eklentisi
* MySQL Veritabanı

Yukarıdaki liste gözünüzü korkutmasın bakanlığımızın yetkilileri gereken eklenti ayarlamalarını da yapıyorlar.

Devam edecek olursak aşağıda eklediğimiz e-posta şablonunu internet\[at\]meb.gov.tr adresine göndermeniz veya size verilen sunucununun yönetim kısmından **Teknik Destek** talebi oluşturmak suretiyle bakanlığa bildirmemiz gerekiyor.

{% file src="../.gitbook/assets/bilgi-islem-dairesi-internet-hizmetlerine-atilacak-e-posta.pdf" %}

## Yukarıdaki adımlar tamam sırada ne var?

Sırada ise yazılımımızı sunucuya yüklemek için gerekli olan FTP işlemleri var. Size tanımlanan  http://\*\*\*\*\*\*odm.meb.gov.tr adresinin barındırma bilgilerini\(FTP kullanıcı adı ve şifresi ile PhpMyAdmin kullanıcı adı şifresi\) bağlı bulunduğunuz müdürlükte çalışan bilgi işlem sorumlularının yardımıyla temin etmelisiniz. 

Biz FTP yazılımı olarak [FileZilla](https://filezilla-project.org/download.php?type=client)'yı tavsiye ediyoruz. Gönderilen dosyaların kuyruğa alınarak gönderilmesi, güvenilir olması ve tabii ki açık kaynak kodlu olmasından dolayı tercih edebilirsiniz. Diğer FTP istemci yazılımlarını elbette kullanabilirisiniz ancak biz FileZilla üzerinden anlatıma devam edeceğiz.



