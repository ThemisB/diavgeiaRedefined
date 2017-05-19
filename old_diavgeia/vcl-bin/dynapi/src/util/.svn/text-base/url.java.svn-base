import java.applet.Applet;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.InputStreamReader;
import java.io.BufferedReader;
import java.net.URL;
import java.net.URLConnection;

public class url extends Applet {
	private static String auth_cookie = null;
	private static StringBuffer c;
	public String readURL( String urlStr, boolean cache, String data, String referer) {
		c = new StringBuffer(8192);
		try {
			if ( cache == false ) urlStr.concat((urlStr.indexOf('?')==-1)?"&":"?").concat("stopCache=").concat(Long.toString(System.currentTimeMillis()));
			URLConnection uc = new URL( urlStr ).openConnection();
			int len = data.length();
			if (len>0) uc.setDoInput( true );
			uc.setDoOutput( true );
			uc.setRequestProperty( "Referer", referer );
			if ( cache == false ) uc.setUseCaches( false );
			if (len>0) {
				byte[] contentBytes = data.getBytes();
				uc.setRequestProperty( "Content-length", Integer.toString( len ) );
				uc.setRequestProperty( "Content-type", "application/x-www-form-urlencoded" );
				OutputStream os = uc.getOutputStream();
				os.write( contentBytes );
				os.flush();
			};
			InputStream is = uc.getInputStream();
			BufferedReader buffer = new BufferedReader(new InputStreamReader(is));
			String line;
			while ((line = buffer.readLine())!=null) c.append(line+"\n");
		} catch ( Exception e ) {
			c.append("Error: " + e);
		};
		return c.toString();
	};
};