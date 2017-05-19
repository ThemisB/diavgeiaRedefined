import org.w3c.dom.*;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import java.io.*;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * User: JesseVitrone
 * Date: May 23, 2003
 */
public class JSCompressor {

    Collection jsCompFiles = new ArrayList();
    ArrayList doubleQuoteStrings;
    ArrayList singleQuoteStrings;
    ArrayList regularExpressions;
    String lineSeparator = "\n";

    public JSCompressor(String configFile) throws Exception {
        init(configFile);
        lineSeparator = System.getProperty("line.separator");
    }


    /**
     * loads the config from the xml file
     * @param configFile
     * @throws Exception
     */
    private void init(String configFile) throws Exception {
        DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
        DocumentBuilder builder = factory.newDocumentBuilder();
        InputStream is = JSCompressor.class.getResourceAsStream(configFile);
        Document document = builder.parse(is);

        Node compressorNode, compressedFileNode, currNode, attrNode, commentNode, inputNode, outputNode, compareNode;
        NodeList compressedFileNodes, nodes, inputGroupNodes;
        List inputFiles, tempFileList;
        String nodeName, comment, compareValue, name;

        compressorNode = document.getFirstChild();
        compressedFileNodes = compressorNode.getChildNodes();

        for (int cfnIndex = 0; cfnIndex < compressedFileNodes.getLength(); cfnIndex++) {
            compressedFileNode = compressedFileNodes.item(cfnIndex);

            if (compressedFileNode.getNodeType() == Node.ELEMENT_NODE) {
                outputNode = compressedFileNode.getAttributes().getNamedItem("name");
                nodes = compressedFileNode.getChildNodes();
                inputFiles = new ArrayList();
                comment = "";

                for (int nodeIndex = 0; nodeIndex < nodes.getLength(); nodeIndex++) {
                    currNode = nodes.item(nodeIndex);

                    if (currNode.getNodeType() == Node.ELEMENT_NODE) {
                        nodeName = currNode.getNodeName();

                        if (nodeName.equals("input-file")) {
                            attrNode = currNode.getAttributes().getNamedItem("name");
                            if (attrNode != null) {
                                inputFiles.add(new JSInputFile(attrNode.getNodeValue()));
                            }
                            else {
                                System.out.println("Cannot file name attribute on input-file tag");
                            }
                        }
                        else if (nodeName.equals("input-group")) {
                            tempFileList = new ArrayList();
                            inputGroupNodes = currNode.getChildNodes();
                            for (int ignIndex = 0; ignIndex < inputGroupNodes.getLength(); ignIndex++) {
                                inputNode = inputGroupNodes.item(ignIndex);

                                if (inputNode.getNodeType() == Node.ELEMENT_NODE) {
                                    name = inputNode.getAttributes().getNamedItem("name").getNodeValue();
                                    compareNode = inputNode.getAttributes().getNamedItem("compare-value");

                                    if (compareNode == null) {
                                        compareValue = null;
                                    }
                                    else {
                                        compareValue = compareNode.getNodeValue();
                                    }

                                    tempFileList.add(new JSInputFile(name, compareValue));
                                }
                            }
                            inputFiles.add(new JSInputGroup(tempFileList));

                        }
                        else if (nodeName.equals("comment")) {
                            commentNode = currNode.getFirstChild();
                            comment = commentNode.getNodeValue();
                        }
                    }
                }

                jsCompFiles.add(new JSCompressedFile(outputNode.getNodeValue(), inputFiles, comment));
            }
        }
    }


    /**
     * The basic compress routine.
     */
    public void compress() {
        ArrayList compressedFiles = null;
        String compressedFile, inputFileName;
        JSCompressedFile currFile;
        Object inputObject;
        JSInputFile inputFile;
        JSInputGroup inputGroup;
        for(Iterator jsFileIt = jsCompFiles.iterator(); jsFileIt.hasNext();) {
            currFile = (JSCompressedFile) jsFileIt.next();
            compressedFiles = new ArrayList();
            for (Iterator inputFileIt = currFile.getInputFiles().iterator(); inputFileIt.hasNext();) {
                inputObject = inputFileIt.next();

                if (inputObject instanceof JSInputFile) {
                    try {
                        inputFile = (JSInputFile) inputObject;
                        inputFileName = inputFile.getFileName();
                        compressedFile = compressFile(inputFileName);
                        currFile.addCompressedCode(inputFileName, compressedFile);
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
                }

                if (inputObject instanceof JSInputGroup) {
                    inputGroup = (JSInputGroup) inputObject;
                    for (Iterator groupIt = inputGroup.getInputFiles().iterator(); groupIt.hasNext();) {
                        inputFile = (JSInputFile) groupIt.next();
                        try {
                            inputFileName = inputFile.getFileName();
                            compressedFile = compressFile(inputFileName);
                            currFile.addCompressedCode(inputFileName, compressedFile);
                        } catch (Exception e) {
                            e.printStackTrace();
                        }
                    }
                }
            }

            writeFile(currFile);
        }
    }


    /**
     * Writes out a compressed file
     * @param compFile
     */
    private void writeFile(JSCompressedFile compFile) {
        try {
            String outputFileName = compFile.getFileName();
            BufferedWriter out = new BufferedWriter(new FileWriter(outputFileName));
            ArrayList inputFiles = (ArrayList) compFile.getInputFiles();
            Object input;

            System.out.println(lineSeparator + " -- Compressed File Summary: ");
            System.out.println("\toutput file name: " + compFile.getFileName());
            System.out.println("\tinput file names:");

            writeComment(compFile.getComment(), out);

            for (Iterator files = inputFiles.iterator(); files.hasNext();) {
                input = files.next();

                if (input instanceof JSInputFile) {
                    writeJSInputFile(compFile, (JSInputFile) input, out);
                }
                else if (input instanceof JSInputGroup) {
                    writeJSInputGroup(compFile, (JSInputGroup) input, out);
                }
                else {
                    System.out.println("don't know how to write instance of " + input.getClass().getName());
                }

            }

            out.close();

        } catch (Exception e) {
            e.printStackTrace();
        }
    }


    /**
     * Writes out the info from the JSInputFile
     */
    private void writeJSInputFile(JSCompressedFile compFile, JSInputFile inputFile, BufferedWriter out) throws IOException {
        String code, compFileName;
        HashMap compressedFiles = compFile.getCompressedCode();

        compFileName = inputFile.getFileName();
        code = (String) compressedFiles.get(compFileName);
        System.out.println("\t\t" + compFileName);
        out.write("/*" + compFileName + "*/ ");
        out.write(code + lineSeparator);
    }


    /**
     * Trim spaces around lines of the comment - might be there from XML formatting
     */
    private void writeComment(String comment, BufferedWriter out) throws IOException {
        StringTokenizer st = new StringTokenizer(comment, lineSeparator);
        String tok;
        while (st.hasMoreTokens()) {
            tok = st.nextToken();
            out.write(tok.trim() + lineSeparator);
        }
    }


    /**
     * Writes out the info from the JSInputGroup
     */
    private void writeJSInputGroup(JSCompressedFile compFile, JSInputGroup inputGroup, BufferedWriter out) throws IOException {
        String code, compFileName, compareValue;
        HashMap compressedFiles = compFile.getCompressedCode();
        JSInputFile inputFile;

        int inputIndex = 0;
        List inputFiles = inputGroup.getInputFiles();

        System.out.println("\t\tinput group:");
        while (inputIndex < inputFiles.size()) {
            inputFile = (JSInputFile) inputFiles.get(inputIndex);

            //write javascript if code
            if (inputIndex == 0) {
                compareValue = inputFile.getCompareValue();
                if (compareValue == null || compareValue.equals("")) {
                    throw new RuntimeException("an <input-file> inside an <input-group> must have a compare-value unless it's the last one in the group");
                }

                compFileName = inputFile.getFileName();
                code = (String) compressedFiles.get(compFileName);
                System.out.println("\t\t\t" + compFileName);
                out.write("if (" + compareValue + ") {" + lineSeparator);
                out.write("/*" + compFileName + "*/ ");
                out.write(code + lineSeparator);
                out.write("}" + lineSeparator);
            }

            //write javascript else if code
            else if (inputIndex < inputFiles.size()-1) {
                compareValue = inputFile.getCompareValue();
                if (compareValue == null || compareValue.equals("")) {
                    throw new RuntimeException("an <input-file> inside an <input-group> must have a compare-value unless it's the last one in the group");
                }

                compFileName = inputFile.getFileName();
                code = (String) compressedFiles.get(compFileName);
                System.out.println("\t\t\t" + compFileName);
                out.write("else if (" + compareValue + ") {" + lineSeparator);
                out.write("/*" + compFileName + "*/ ");
                out.write(code + lineSeparator);
                out.write("}" + lineSeparator);

            }

            //write javascript else code
            else {
                compFileName = inputFile.getFileName();
                code = (String) compressedFiles.get(compFileName);
                System.out.println("\t\t\t" + compFileName);
                out.write("else {" + lineSeparator);
                out.write("/*" + compFileName + "*/ ");
                out.write(code + lineSeparator);
                out.write("}" + lineSeparator);
            }

            inputIndex++;
        }
    }



    /**
     * Compress the given file.
     * @param inputFile The input file as one long string
     * @return the compressed file as one long string
     * @throws Exception
     */
    public String compressFile(String inputFile) throws Exception {
        String compString = "";

        compString = getFileAsString(inputFile);
        compString = removeDoubleQuoteStrings(compString);
        compString = removeSingleQuoteStrings(compString);
        compString = removeLineComments(compString);
        compString = removeRegularExpressionStrings(compString);
        compString = compressWhiteSpace(compString);
        compString = removeMultilineComments(compString);
        compString = combineLiteralStrings(compString);
        compString = restoreRegularExpressions(compString);
        compString = restoreSingleQuotes(compString);
        compString = restoreDoubleQuotes(compString);

        return compString;
    }


    /**
     * Remove line comments
     * @param compString
     * @return
     */
    public String removeLineComments(String compString) {
        Pattern lcPat = Pattern.compile("//.*" + lineSeparator);
        Matcher lcMatch = lcPat.matcher(compString);
        compString = lcMatch.replaceAll(lineSeparator);

        return compString;
    }

    /**
     * Remove multiple line comments
     * @param compString
     * @return
     */
    public String removeMultilineComments(String compString) {
        Pattern cPat = Pattern.compile("\\/\\*.*?\\*\\/");
        Matcher cMatch = cPat.matcher(compString);
        compString = cMatch.replaceAll(" ");

        return compString;
    }


    /**
     * Compress unnecessary white space
     * @param compString
     * @return
     */
    public String compressWhiteSpace(String compString) {

        Pattern wsPat;
        Matcher wsMatcher;

        wsPat = Pattern.compile("\\s+");
        wsMatcher = wsPat.matcher(compString);
        compString = wsMatcher.replaceAll(" ");

        wsPat = Pattern.compile("(.*)\\s$");
        wsMatcher = wsPat.matcher(compString);
        compString = wsMatcher.replaceFirst("$1");

        wsPat = Pattern.compile("^\\s(.*)");
        wsMatcher = wsPat.matcher(compString);
        compString = wsMatcher.replaceFirst("$1");

        wsPat = Pattern.compile("\\s([\\x21\\x25\\x26\\x28\\x29\\x2a\\x2b\\x2c\\x2d\\x3a\\x3b\\x3c\\x3d\\x3e\\x3f\\x5b\\x5d\\x5c\\x7b\\x7c\\x7d\\x7e])");
        wsMatcher = wsPat.matcher(compString);
        compString = wsMatcher.replaceAll("$1");

        wsPat = Pattern.compile("([\\x21\\x25\\x26\\x28\\x29\\x2a\\x2b\\x2c\\x2d\\x3a\\x3b\\x3c\\x3d\\x3e\\x3f\\x5b\\x5d\\x5c\\x7b\\x7c\\x7d\\x7e])\\s");
        wsMatcher = wsPat.matcher(compString);
        compString = wsMatcher.replaceAll("$1");

        return compString;
    }


    /**
     * Remove the double quoted strings from the given string and store them.
     * @param compString
     * @return
     */
    public String removeDoubleQuoteStrings(String compString) {
        doubleQuoteStrings = new ArrayList();
        StringTokenizer st = new StringTokenizer(compString, lineSeparator, true);
        String parsedCode = "", remainingCode = "", literalString = "";
        Pattern pat;
        Matcher match;
        int lsIndex = 0;
        while (st.hasMoreTokens()) {
            remainingCode = st.nextToken();
            while (remainingCode.length() != 0) {
                pat = Pattern.compile("([^\"]*)\"([^\"\\\\]*(?:\\\\.[^\"\\\\]*)*)\"(.*)");
                match = pat.matcher(remainingCode);
                if (match.matches()) {
                    parsedCode += match.group(1) + "_!_dq" + lsIndex++ + "_!_";
                    literalString = match.group(2);
                    remainingCode = match.group(3);
                    doubleQuoteStrings.add(literalString);
                }
                else {
                    parsedCode += remainingCode;
                    break;
                }
            }
        }

        return parsedCode;
    }


    /**
     * Remove the single quoted strings from the given string and store them.
     * @param compString
     * @return
     */
    public String removeSingleQuoteStrings(String compString) {
        singleQuoteStrings = new ArrayList();
        StringTokenizer st = new StringTokenizer(compString, lineSeparator, true);
        String parsedCode = "", remainingCode = "", literalString = "";
        Pattern pat;
        Matcher match;
        int lsIndex = 0;
        while (st.hasMoreTokens()) {
            remainingCode = st.nextToken();
            while (remainingCode.length() != 0) {
                pat = Pattern.compile("([^\']*)\'([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\'(.*)");
                match = pat.matcher(remainingCode);
                if (match.matches()) {
                    parsedCode += match.group(1) + "_!_sq" + lsIndex++ + "_!_";
                    literalString = match.group(2);
                    remainingCode = match.group(3);
                    singleQuoteStrings.add(literalString);
                }
                else {
                    parsedCode += remainingCode;
                    break;
                }
            }
        }

        return parsedCode;
    }


    /**
     * Remove the regular expressions from the given string and store them.
     * @param compString
     * @return
     */
    public String removeRegularExpressionStrings(String compString) {
        regularExpressions = new ArrayList();
        StringTokenizer st = new StringTokenizer(compString, lineSeparator, true);
        String parsedCode = "", remainingCode = "", literalString = "";
        Pattern pat;
        Matcher match;
        int lsIndex = 0;
        while (st.hasMoreTokens()) {
            remainingCode = st.nextToken();
            while (remainingCode.length() != 0) {
                //pat = Pattern.compile("([^\"]*)\"([^\"\\\\]*(?:\\\\.[^\"\\\\]*)*)\"(.*)");
                pat = Pattern.compile("([^\\/]*)\\/([^\\/\\\\]*(?:\\\\.[^\\/\\\\]*)*)\\/(.*)");
                match = pat.matcher(remainingCode);
                if (match.matches()) {
                    parsedCode += match.group(1) + "_!_re" + lsIndex++ + "_!_";
                    literalString = match.group(2);
                    remainingCode = match.group(3);
                    regularExpressions.add(literalString);
                }
                else {
                    parsedCode += remainingCode;
                    break;
                }
            }
        }

        return parsedCode;
    }


    /**
     * Combine the literal strings that are just being added
     * IE - "strong"+"bad" --> "strongbad";
     * Doesn't actually do anything yet...will add later.
     * @param compString
     * @return
     */
    public String combineLiteralStrings(String compString) {
        return compString;
    }


    /**
     * Restore the single quote strings from the stored list.
     * @param compString
     * @return
     */
    private String restoreSingleQuotes(String compString) {
        int id;
        String token;
        StringBuffer code = new StringBuffer();
        JSTokenizer st = new JSTokenizer(compString, "_!_");

        while (st.hasMoreTokens()) {
            token = st.nextToken();
            code.append(token);

            if (st.hasMoreTokens()) {
                token = st.nextToken();
                id = getReplacementId(token);
                if (token.startsWith("sq")) {
                    code.append("\'" + singleQuoteStrings.get(id) + "\'");
                }
                else {
                    code.append("_!_" + token + "_!_");
                }
            }
        }

        return code.toString();
    }


    /**
     * Restore the regular expressions strings from the stored list.
     * @param compString
     * @return
     */
    private String restoreRegularExpressions(String compString) {
        int id;
        String token;
        StringBuffer code = new StringBuffer();
        JSTokenizer st = new JSTokenizer(compString, "_!_");

        while (st.hasMoreTokens()) {
            token = st.nextToken();
            code.append(token);

            if (st.hasMoreTokens()) {
                token = st.nextToken();
                id = getReplacementId(token);
                if (token.startsWith("re")) {
                    code.append("/" + regularExpressions.get(id) + "/");
                }
                else {
                    code.append("_!_" + token + "_!_");
                }
            }
        }

        return code.toString();
    }


    /**
     * Restore the double quote strings from the stored list.
     * @param compString
     * @return
     */
    private String restoreDoubleQuotes(String compString) {
        int id;
        String token;
        StringBuffer code = new StringBuffer();
        JSTokenizer st = new JSTokenizer(compString, "_!_");

        while (st.hasMoreTokens()) {
            token = st.nextToken();
            code.append(token);

            if (st.hasMoreTokens()) {
                token = st.nextToken();
                id = getReplacementId(token);
                if (token.startsWith("dq")) {
                    code.append("\"" + doubleQuoteStrings.get(id) + "\"");
                }
                else {
                    code.append("_!_" + token + "_!_");
                }

            }
        }

        return code.toString();
    }


    /**
     * Figure out what the id for the token is.
     * Tokens start with "dq", "sq" or "re", then the id.
     */
    private int getReplacementId(String token) {
        int id = 0;
        token = token.substring(2);
        id = Integer.parseInt(token);
        return id;
    }


    /**
     * Take the given input file name, read it in, and return it as a string.
     * @param inputFileName The file name to read.
     * @return The file as a string.
     * @throws Exception
     */
    private String getFileAsString(String inputFileName) throws Exception {
        StringBuffer fileString = new StringBuffer();
        BufferedReader reader = new BufferedReader(new FileReader(inputFileName));
        while (reader.ready()) {
            fileString.append(reader.readLine() + System.getProperty("line.separator"));
        }
        reader.close();

        return fileString.toString();
    }


    private String removeExtraSpacesFromComments(String comments) {
        String newString = "";

//        pat = Pattern.compile("([^\\/]*)\\/([^\\/\\\\]*(?:\\\\.[^\\/\\\\]*)*)\\/(.*)");
//        match = pat.matcher(remainingCode);
//        if (match.matches()) {
//            parsedCode += match.group(1) + "_!_re" + lsIndex++ + "_!_";
//            literalString = match.group(2);
//            remainingCode = match.group(3);
//            regularExpressions.add(literalString);
//        }
//        else {
//            parsedCode += remainingCode;
//            break;
//        }
//



        return newString;
    }


    /**
     * Reads the config param and kicks off the compressor
     * @param args
     * @throws Exception
     */
    public static void main(String[] args) throws Exception {
        System.out.println(System.getProperty("line.separator") + " ---- Compressing Files  ---- " + System.getProperty("line.separator"));
        String configFile = "jsCompressor.xml";
        if (args.length > 0) {
            if (args[0].equals("-config")) {
                configFile = args[1];
            }
        }

        System.out.println(" -- Using configuration found in " + configFile);
        JSCompressor jsc = new JSCompressor(configFile);
        jsc.compress();
    }
}


/**
 * JSTokenizer class.
 * This works pretty much like the normal String tokenizer,
 * except the second param works a little different.
 *
 * The norm StringTokenizer class takes the second param string and treats
 * each character as a delimiter.  This makes it impossible for me to split
 * a string with a delimiter more than one character.
 *
 * This tokenizer class treats the delimiter param as a whole string, not individual chars.
 */
class JSTokenizer {
    String str;
    String delim;
    int searchedIndex = 0;


    public JSTokenizer(String str, String delim) {
        this.str = new String(str);
        this.delim = delim;
    }

    public boolean hasMoreTokens() {
        return (searchedIndex < str.length());
    }

    public String nextToken() {
        int index = str.indexOf(delim, searchedIndex);
        String token = "";

        if (searchedIndex < str.length()) {
            if (index >= 0) {
                token = str.substring(searchedIndex, index);
                searchedIndex = index + delim.length();
            } else {
                token = str.substring(searchedIndex, str.length());
                searchedIndex = str.length()+1;
            }
        } else {
            throw new RuntimeException("No more tokens.  Use hasNext() to check token availability.");
        }

        return token;
    }

}


/**
 * Just an easy way to pass around information about a file to be compressed.
 */
class JSCompressedFile {
    String     fileName;
    String     comment;
    Collection inputFiles;
    HashMap    compressedCode = new HashMap();
    boolean    browserDependant = false;

    public JSCompressedFile(String fileName, Collection inputFiles, String comment) {
        this.fileName   = fileName;
        this.inputFiles = inputFiles;
        this.comment    = comment;

        if (fileName.indexOf("_dom") >= 0 || fileName.indexOf("_ie") >= 0 || fileName.indexOf("_ns4") >= 0) {
            browserDependant = true;
            setBrowserFiles();
        }

    }

    private void setBrowserFiles() {

    }

    public String getFileName() {
        return fileName;
    }

    public void setFileName(String fileName) {
        this.fileName = fileName;
    }

    public Collection getInputFiles() {
        return inputFiles;
    }

    public void setInputFiles(Collection inputFiles) {
        this.inputFiles = inputFiles;
    }

    public void addCompressedCode(String key, String code) {
        compressedCode.put(key, code);
    }

    public HashMap getCompressedCode() {
        return compressedCode;
    }

    public void setCompressedCode(HashMap compressedCode) {
        this.compressedCode = compressedCode;
    }

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }

    public boolean isBrowserDependant() {
        return browserDependant;
    }

    public void setBrowserDependant(boolean browserDependant) {
        this.browserDependant = browserDependant;
    }

}

/**
 * Just an easy way to store information about an input file.
 */
class JSInputFile {
    String fileName;
    String compareValue;

    public JSInputFile(String fileName) {
        this.fileName = fileName;
    }

    public JSInputFile(String fileName, String compareValue) {
        this.fileName = fileName;
        this.compareValue = compareValue;
    }

    public String getFileName() {
        return fileName;
    }

    public void setFileName(String fileName) {
        this.fileName = fileName;
    }

    public String getCompareValue() {
        return compareValue;
    }

    public void setCompareValue(String compareValue) {
        this.compareValue = compareValue;
    }

}

/**
 * Just a grouping a inputFiles
 */
class JSInputGroup {
    List inputFiles;

    public JSInputGroup(List inputFiles) {
        this.inputFiles = inputFiles;
    }

    public List getInputFiles() {
        return inputFiles;
    }

    public void setInputFiles(List inputFiles) {
        this.inputFiles = inputFiles;
    }
}