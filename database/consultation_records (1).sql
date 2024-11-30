
CREATE TABLE consultation_records (
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    organization_id INT NOT NULL,
    top_5_disease TEXT,
    prescribed_medicine TEXT,
    transcribe_summary TEXT,
    consultation_date_time TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(user_id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id),
    FOREIGN KEY (organization_id) REFERENCES organizations(organization_id)
);
