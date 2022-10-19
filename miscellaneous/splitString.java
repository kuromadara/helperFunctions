class HelloWorld {
    public static void main(String[] args) {
        String input = "0987654_32323a";
        String begining = input.split("_")[0];
        String end = input.split("_")[1];
        System.out.println("begining: "+begining);
        System.out.println("end: "+end);
    }
}
