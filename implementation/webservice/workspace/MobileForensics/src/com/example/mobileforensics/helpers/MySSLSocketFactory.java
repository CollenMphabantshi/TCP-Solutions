package com.example.mobileforensics.helpers;

import java.io.IOException;
import java.net.InetAddress;
import java.net.Socket;
import java.net.UnknownHostException;
import java.security.KeyStore;
import java.security.cert.X509Certificate;

import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

import org.apache.http.conn.ssl.SSLSocketFactory;



public class MySSLSocketFactory extends SSLSocketFactory{
	SSLContext sslContext = SSLContext.getInstance("TLS");

    public MySSLSocketFactory(KeyStore truststore)
                    throws Exception {
            super(truststore);

            TrustManager tm = new X509TrustManager() {
                    public void checkClientTrusted(X509Certificate[] chain,
                                    String authType) {
                    }

                    public void checkServerTrusted(X509Certificate[] chain,
                                    String authType) {
                    }

                    public X509Certificate[] getAcceptedIssuers() {
                            return null;
                    }
            };

            sslContext.init(null, new TrustManager[] { tm }, null);
    }

    @Override
    public Socket createSocket(Socket socket, String host, int port,
                    boolean autoClose) throws IOException, UnknownHostException {
            return sslContext.getSocketFactory().createSocket(socket, host, port,
                            autoClose);
    }

    @Override
    public Socket createSocket() throws IOException {
            return sslContext.getSocketFactory().createSocket();
    }


	
		
}
