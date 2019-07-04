<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016092600601879",

		//商户私钥
		'merchant_private_key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCkZuTisQ37GGySCMl1MrUrnlLHx2JBPZnolNA1/qDnjuuR2sz03rqdZkwx3uG411nEwsooTC5gA4skiAF9Q5C7ipo+UkQxihmE6PFqpMK1A1vY+i6OmhfjR0Xk5Y7TnUlv+yhtXF/7cwFI0vCXTLTy2APW/dUSnvlzWM3tjJRYgMag/IGw0FvvrPrBDAo078Z2myU261XrQdQcj1T4o1PLxQfXa7WAzj7zOOEGmjcR0KmUvDStiUFvjYVbQTHwONJuFu02c9yjzHGjxDdH+iq6qLXiPWkcAasWL0/HxRVSCvmpT+AcpoD+QdB/hrHQDbNYWRsuFfos20aL7NEZkUk5AgMBAAECggEBAJi1qy6XYHE5QsBzwQ5IR9l4e1RvdGk9m1VbxfwhxbzSGSemonNi4N2MRIKekfVstEn81mOQQBOXtwv7+cYtmKdcG+J/8DBEI2g+KOHyoZoawJpP6ic0I7ROZDI2ufD/TVPjbK4I/G9JaIwIxMsFyZ854Hc32VAus2/dsYtS5gk+N9ty5ZZy8FV4lk+Exjf3Rw1Nu+lgho87xeaEpGTf2xzXkkXG8stz8wDq8ulJtvkYbyE/5YvW9YKelLRfwtmJhlgxKEcByLb52h8QUPdSe34eUiVA1pAJCCgoYH5SfYT69jjX87t6n6MCsZ4RMdhFfz5mhzsdER7XjqmVYeffXHECgYEA1SMxO1l3+wXa1VoYRfhQGWMpS5GQehrXp2rmTpdnS14zkrIYGpuSeCY60PvHy9nvmkE+NU1V7jy2ltrXmmz5l1biAk2pqqGaEyrcgMSL8PFcbJs/ZIV2lEis1sZUnUyWG0VOouZ0zZS18FuywcV385WbYriJHvicXRPZbvQNlB8CgYEAxXavGFjBiEGSlIWSB13bG+ym6mL6I0EW3zCMO1fQS0FVlApbdUX+XopBR8lNHFUZj5i7WV6iTgcjVfjzSt7Rwn4859jinuexWMQeZezVceHQxJgs0J/DUjW2yJMl1ZllWKFXmJpe3oBDCaJlCWJxuGkLLLyEYKEXk/ZzyYG9N6cCgYB7hh/cQ6fzhZskF0kGFDln3T5rm3teKPxe/OdpGPo2hevh0vGBSjSDCbUAtUs/65ifj7xb6+wnXGx91WsrBolImoP1zcjNKUdAYJDW2BI6m8dy8i61NVxZ6ByzhNI5L8+3El3WrzV2h/9BxAM/phA0zbn2ZvihSHhmwUA8u5i7BQKBgFpHX9hGw/zS1fxXcSMzEvkaYlno9KnnmVhjbsm25UFy1nh/n77nSFva4+u5KisY8T3Iu2cpsBTyiIJG9py1cLt2UcxCSaITFe8agzdgZ1nQv00SsfKUCI3uhun+9J5Kqp4x7cWUVmltxLiD6aO3wXxpcjV63x76p7f7RobLbUIjAoGBAIqohGrzr5/at1x2sL23FFn/2ALT7Hl4C9uedu/7gf3Ij/108z+BES3IFXxoUvoUd8G3Xvch3dpi0H4kzFdDFXJK06tdTB+pBg65M/axiGplTymo8oQ1RlHUnBSefElBzT8S1yxNcCyuVEd4TPi+1LRsJQyEmhEAz8nKjcRC6idU",
		
		//异步通知地址
		'notify_url' => "http://".$_SERVER['HTTP_HOST'].":80/service/pay/notify",
		
		//同步跳转
		'return_url' => "http://".$_SERVER['HTTP_HOST']."/service/pay/call_back",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAh4Ld9WUsq5rTOO+BmNNPXDRe/HsE9DtItmhqNl6RuuZH2+rgG7nDG3TbySHqmlXQKTkBEY8TnWodTnxuSyMsBmRhW9GDt832QZmjTO9ZqMf9BP90wfxfG+a/mPFUjcKOk3E0YenAPZ/eEpxVQorZ+Bo2xdRYkJ/D8sx6NrwWpYt5IO9OHy5CpR4QeueTsIUdBT1NyZhVYIg+PD2pV/wuxDOyWafmHuTSec+yQdkhIXyH917ZFjsjjhHwL89PAuwPC9WmJUhycaKxeLyZVEcubPMv6l4h6HcsknrUVivIXII/0OwVkDjHUlF9PzwUA6wZlylJ+1Hn0g8aeRFgLQDaywIDAQAB",
);