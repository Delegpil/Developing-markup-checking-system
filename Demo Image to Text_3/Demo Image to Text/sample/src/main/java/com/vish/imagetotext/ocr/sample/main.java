package com.vish.imagetotext.ocr.sample;

import android.Manifest;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.ComponentName;
import android.content.ContentResolver;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.content.pm.ResolveInfo;
import android.content.res.AssetManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.ColorMatrix;
import android.graphics.ColorMatrixColorFilter;
import android.graphics.Paint;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.os.Parcelable;
import android.provider.MediaStore;

import android.system.ErrnoException;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import com.example.croppersample.R;
import com.example.croppersample.data;
import com.theartofdev.edmodo.cropper.CropImageView;

import java.util.List;

public class main extends Activity
{
    public static String URL = "http://192.168.43.173/diplom2/uploadimage.php";
    private static final String IMAGE_CAPTURE_FOLDER = "imageupload/uploads";
    private static final int CAMERA_PIC_REQUEST = 1111;
    private static File file;
    private TextView resultText;
    private static String _bytes64Sting, _imageFileName; //zurag serverluu ilgeeh heseg
    private CropImageView mCropImageView;
    EditText textView;
    private TessOCR mTessOCR;
    private Uri mCropImageUri;
    public static final String lang = "eng";
    public static final String DATA_PATH = Environment.getExternalStorageDirectory().toString() + "/DemoOCR/";
    private ProgressDialog mProgressDialog;
    Button button;
    String hiceel_code, cipher, soril;
    Context ctx=this;
    public Uri outputFileUri;
    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.a_main);
        _imageFileName = String.valueOf(System.currentTimeMillis());
        textView = (EditText)findViewById(R.id.editText);
        mCropImageView = (CropImageView)findViewById(R.id.CropImageView);

        String[] paths = new String[] {DATA_PATH, DATA_PATH + "tessdata/"} ;
        for (String path : paths)
        {
            File dir = new File(path);
            if (!dir.exists())
            {
                if (!dir.mkdirs())
                {
                    Log.v("Main", "ERROR: Creation of directory " + path + " on sdcard failed");
                    break;
                }
                else
                {
                    Log.v("Main", "Created directory " + path + " on sdcard");
                }
            }
        }
        if (!(new File(DATA_PATH + "tessdata/" + lang + ".traineddata")).exists()) {
            try
            {
                AssetManager assetManager = getAssets();
                InputStream in = assetManager.open(lang + ".traineddata");
                OutputStream out = new FileOutputStream(DATA_PATH + "tessdata/" + lang + ".traineddata");
                // Transfer bytes from in to out
                byte[] buf = new byte[1024];
                int len;
                while ((len = in.read(buf)) > 0)
                {
                    out.write(buf, 0, len);
                }
                in.close();
                out.close();
            }
            catch (IOException e)
            {
                // Log.e(TAG, "Was unable to copy " + lang + " traineddata " + e.toString());
            }
        }
        mTessOCR =new TessOCR();
        //Database button onClick oruulah
        button = (Button) findViewById(R.id.dbbutton);
        button.setOnClickListener(new View.OnClickListener()
        {
            public void onClick(View v)
            {
                String strTemp = textView.getText().toString();
                String[] words = strTemp.split(" ");
                hiceel_code = words[0].toString();
                cipher = words[1].toString();
                soril = words[2].toString();
               /* Toast.makeText(ctx, hiceel_code, Toast.LENGTH_LONG).show();
                Toast.makeText(ctx, cipher, Toast.LENGTH_LONG).show();*/

               /* Database b = new Database();
                b.execute(hiceel_code, cipher, soril);*/
                uploadImage(outputFileUri.getPath(), hiceel_code, soril, cipher);
                Toast.makeText(ctx, "Амжилттай дамжигдлаа", Toast.LENGTH_LONG).show();
                Intent myIntent = new Intent(getApplicationContext(),  main.class);
                myIntent.putExtra("tempstring", strTemp);
                startActivity(myIntent);

            }
        });
    }
    //ugugfliin sand oyutnii ner code oruulj bgaa heseg
    /*class Database extends AsyncTask<String, String, String>
    {
        @Override     protected String doInBackground(String... params)
        {
            String hiceel_code = params[0];
            String cipher = params[1];
            String soril = params[2];
            String data="";
            int tmp;
            try
            {
                URL url = new URL("http://192.168.43.223/logindb/app2/register.php");
                String urlParams = "hiceel_code="+hiceel_code+"&cipher="+cipher+"&soril="+soril;
                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                httpURLConnection.setDoOutput(true);
                OutputStream os = httpURLConnection.getOutputStream();
                os.write(urlParams.getBytes());
                os.flush();
                os.close();
                InputStream is = httpURLConnection.getInputStream();
                while((tmp=is.read())!=-1){
                    data+= (char)tmp;
                }
                is.close();
                httpURLConnection.disconnect();

                return data;

            }
            catch (MalformedURLException e)
            {
                e.printStackTrace();
                return "Exception: "+e.getMessage();
            }
            catch (IOException e)
            {
                e.printStackTrace();
                return "Exception: "+e.getMessage();
            }
        }
        @Override
        protected void onPostExecute(String s)
        {
            if(s.equals(""))
            {
                s="Өгөгдөл амжилттай хадгалагдлаа.";
            }
            Toast.makeText(ctx, s, Toast.LENGTH_LONG).show();
        }
    }*/


    /**
     * On load image button click, start pick image chooser activity.
     */
    public void onLoadImageClick(View view)
    {
        startActivityForResult(getPickImageChooserIntent(), 200);
    }
    /**
     zurag croploj bga hseg
     */
    public void onCropImageClick(View view)
    {
        Bitmap cropped = mCropImageView.getCroppedImage(500, 500);
        if (cropped != null)
            mCropImageView.setImageBitmap(cropped);
        doOCR(convertColorIntoBlackAndWhiteImage(cropped) );
    }

    public void doOCR(final Bitmap bitmap)
    {
        if (mProgressDialog == null)
        {
            mProgressDialog = ProgressDialog.show(this, "Шалгаж байна","Түр хүлээнэ үү...", true);
        }
        else
        {
            mProgressDialog.show();
        }

        new Thread(new Runnable()
        {
            public void run()
            {
                final String result = mTessOCR.getOCRResult(bitmap).toLowerCase();
                runOnUiThread(new Runnable()
                {
                    @Override
                    public void run()
                    {
                        // TODO Auto-generated method stub
                        if (result != null && !result.equals(""))
                        {
                            String s = result.trim();
                            textView.setText(result);
                        }
                        mProgressDialog.dismiss();
                    }
                });
            };
        }).start();
    }
    //zurgiig har tsagaan bolgoj bga heseg
    private Bitmap convertColorIntoBlackAndWhiteImage(Bitmap orginalBitmap)
    {
        ColorMatrix colorMatrix = new ColorMatrix();
        colorMatrix.setSaturation(0);
        ColorMatrixColorFilter colorMatrixFilter = new ColorMatrixColorFilter(colorMatrix);
        Bitmap blackAndWhiteBitmap = orginalBitmap.copy(
                Bitmap.Config.ARGB_8888, true);

        Paint paint = new Paint();
        paint.setColorFilter(colorMatrixFilter);

        Canvas canvas = new Canvas(blackAndWhiteBitmap);
        canvas.drawBitmap(blackAndWhiteBitmap, 0, 0, paint);

        return blackAndWhiteBitmap;
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data)
    {
        if (resultCode == Activity.RESULT_OK)
        {
            Uri imageUri = getPickImageResultUri(data);
            boolean requirePermissions = false;
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M &&
                    checkSelfPermission(Manifest.permission.READ_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED &&
                    isUriRequiresPermissions(imageUri))
            {
                requirePermissions = true;
                mCropImageUri = imageUri;
                requestPermissions(new String[]{Manifest.permission.READ_EXTERNAL_STORAGE}, 0);
            }

            if (!requirePermissions)
            {
                mCropImageView.setImageUriAsync(imageUri);
            }

        }
        else if (resultCode == RESULT_CANCELED)
        {
            // user cancelled Image capture
            Toast.makeText(getApplicationContext(), "Хэрэглэгч цуцлах товчийг дарлаа.", Toast.LENGTH_SHORT).show();
        }
        else
        {
            // failed to capture image
            Toast.makeText(getApplicationContext(),"Уучлаарай! Дарсан зурагт алдаа гарлаа", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults)
    {
        if (mCropImageUri != null && grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED)
        {
            mCropImageView.setImageUriAsync(mCropImageUri);
        } else
        {
            Toast.makeText(this, "Required permissions are not granted", Toast.LENGTH_LONG).show();
        }
    }

    public Intent getPickImageChooserIntent()
    {
        // zurag
        outputFileUri = getCaptureImageOutputUri();

        List<Intent> allIntents = new ArrayList<>();
        PackageManager packageManager = getPackageManager();

        // xurag songoh bolon darah heseg
        Intent captureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        captureIntent.putExtra(MediaStore.EXTRA_SIZE_LIMIT, 1024*1024);
        outputFileUri = Uri.fromFile(getFile());
        List<ResolveInfo> listCam = packageManager.queryIntentActivities(captureIntent, 0);
        for (ResolveInfo res : listCam)
        {
            Intent intent = new Intent(captureIntent);
            intent.setComponent(new ComponentName(res.activityInfo.packageName, res.activityInfo.name));
            intent.setPackage(res.activityInfo.packageName);
            if (outputFileUri != null)
            {
                //zurag gargaj bgaa heseg
                intent.putExtra(MediaStore.EXTRA_OUTPUT, outputFileUri);
            }
            allIntents.add(intent);
        }
        // collect all gallery intents
        Intent galleryIntent = new Intent(Intent.ACTION_GET_CONTENT);
        galleryIntent.setType("image/*");
        List<ResolveInfo> listGallery = packageManager.queryIntentActivities(galleryIntent, 0);
        for (ResolveInfo res : listGallery)
        {
            Intent intent = new Intent(galleryIntent);
            intent.setComponent(new ComponentName(res.activityInfo.packageName, res.activityInfo.name));
            intent.setPackage(res.activityInfo.packageName);
            allIntents.add(intent);
        }

        // the main intent is the last in the list (fucking android) so pickup the useless one
        Intent mainIntent = allIntents.get(allIntents.size() - 1);
        for (Intent intent : allIntents)
        {
            if (intent.getComponent().getClassName().equals("com.android.documentsui.DocumentsActivity"))
            {
                mainIntent = intent;
                break;
            }
        }
        allIntents.remove(mainIntent);
        Intent chooserIntent = Intent.createChooser(mainIntent, "Select source");

        chooserIntent.putExtra(Intent.EXTRA_INITIAL_INTENTS, allIntents.toArray(new Parcelable[allIntents.size()]));
        return chooserIntent;
    }

    private Uri getCaptureImageOutputUri()
    {
        //darsan zurag
        return outputFileUri;
    }

    public Uri getPickImageResultUri(Intent data)
    {
        boolean isCamera = true;

        if (data != null && data.getData() != null)
        {
            String action = data.getAction();
            isCamera = action != null && action.equals(MediaStore.ACTION_IMAGE_CAPTURE);
        }
        return isCamera ? getCaptureImageOutputUri() : data.getData();
    }

    public boolean isUriRequiresPermissions(Uri uri)
    {
        try
        {
            ContentResolver resolver = getContentResolver();
            InputStream stream = resolver.openInputStream(uri);
            stream.close();
            return false;
        }
        catch (FileNotFoundException e)
        {
            if (e.getCause() instanceof ErrnoException)
            {
                return true;
            }
        }
        catch (Exception e)
        {
        }
        return false;
    }
    private void uploadImage(String picturePath,String hiceel_code, String soril, String cipher)
    {
        Bitmap bm = BitmapFactory.decodeFile(picturePath);
        ByteArrayOutputStream bao = new ByteArrayOutputStream();
        bm.compress(Bitmap.CompressFormat.JPEG, 90, bao);
        byte[] byteArray = bao.toByteArray();
        _bytes64Sting = Base64.encodeBytes(byteArray);
        RequestPackage rp = new RequestPackage();
        rp.setMethod("POST");
        rp.setUri(URL);
        rp.setSingleParam("image", _bytes64Sting);
        rp.setSingleParam("ImageName", _imageFileName + ".jpg");
        rp.setSingleParam("hicheel_code", hiceel_code);
        rp.setSingleParam("soril", soril);
        rp.setSingleParam("cipher", cipher);
        // Upload image to server
        new uploadToServer().execute(rp);

    }
    public class uploadToServer extends AsyncTask<RequestPackage, Void, String>
    {
        private ProgressDialog pd = new ProgressDialog(main.this);
        protected void onPreExecute()
        {
            super.onPreExecute();
            pd.setMessage("Өгөгдөл дамжуулж байна!");
            pd.setCancelable(false);
            pd.show();
        }
        @Override
        protected String doInBackground(RequestPackage... params)
        {
            String content = MyHttpURLConnection.getData(params[0]);
            return content;
        }
        protected void onPostExecute(String result)
        {
            super.onPostExecute(result);
            pd.hide();
            pd.dismiss();
        }
    }
    private File getFile()
    {
        String filepath = Environment.getExternalStorageDirectory().getPath();
        file = new File(filepath, IMAGE_CAPTURE_FOLDER);
        if (!file.exists())
        {
            file.mkdirs();
        }
        return new File(file + File.separator + _imageFileName + ".jpg");
    }

}