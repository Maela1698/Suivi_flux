import cv2
from pyzbar.pyzbar import decode
import os

def read_qr_from_image(file_path):
    if not os.path.exists(file_path):
        print("The file does not exist.")
        return None

    image = cv2.imread(file_path)
    qr_codes = decode(image)

    if not qr_codes:
        print("No QR code found in the image.")
        return None

    for qr_code in qr_codes:
        qr_data = qr_code.data.decode('utf-8')
        print("QR Code Data:", qr_data)
        return qr_data

    return None

def read_qr_from_webcam():
    cap = cv2.VideoCapture(0)

    if not cap.isOpened():
        print("Could not open webcam.")
        return None

    print("Press 'q' to quit and 's' to scan for QR code.")

    while True:
        ret, frame = cap.read()
        if not ret:
            print("Failed to capture image.")
            break

        cv2.imshow("QR Code Scanner - Press 's' to scan or 'q' to quit", frame)
        key = cv2.waitKey(1) & 0xFF
        if key == ord('s'):
            qr_codes = decode(frame)
            if qr_codes:
                for qr_code in qr_codes:
                    qr_data = qr_code.data.decode('utf-8')
                    print("QR Code Data:", qr_data)
                    cap.release()
                    cv2.destroyAllWindows()
                    return qr_data
            else:
                print("No QR code detected. Try again.")

        elif key == ord('q'):
            break

    cap.release()
    cv2.destroyAllWindows()
    return None

def main():
    print("Choose an option:")
    print("1. Scan QR Code from an Image")
    print("2. Scan QR Code from Webcam")
    choice = input("Enter your choice (1 or 2): ")

    if choice == '1':
        file_path = input("Enter the path of the image file: ")
        read_qr_from_image(file_path)
    elif choice == '2':
        read_qr_from_webcam()
    else:
        print("Invalid choice. Please select 1 or 2.")

if __name__ == "__main__":
    main()
