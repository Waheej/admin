"use client";
import clsx from "clsx";
import { ErrorMessage, Field, FieldProps, useFormikContext } from "formik";
import { useLocale } from "next-intl";
import React, { useEffect, useState } from "react";
import { IoChevronDown } from "react-icons/io5";
import PhoneInput, { parsePhoneNumber } from "react-phone-number-input";
import "react-phone-number-input/style.css";

type Option = { label: string; value: string };

type Props = {
    name: string;
    type?: string;
    placeholder?: string;
    customClass?: string;
    as?: "input" | "select" | "textarea";
    options?: Option[];
    value?: string;
    onChange?: (e: React.ChangeEvent<any>) => void;
    indicatorIcon?: React.ReactNode;
    indicatorColor?: string;
    disabled?: boolean;
    readOnly?: boolean;
    isPhone?: boolean;
    defaultCountry?: string;
    onPhoneChange?: (data: { countryCode: string; phoneNumber: string }) => void;
};

const GeneralInput: React.FC<Props> = ({
    name,
    type = "text",
    placeholder,
    customClass,
    as = "input",
    options = [],
    value,
    onChange,
    indicatorIcon = <IoChevronDown size={18} />,
    indicatorColor = "#000",
    disabled,
    readOnly,
    isPhone = false,
    defaultCountry = "SA",
    onPhoneChange,
}) => {
    const lang = useLocale();
    const isArabic = lang === "ar";

    // Only use Formik context when not using controlled props (value/onChange)
    const shouldUseFormik = value === undefined && onChange === undefined;
    let formik: any = null;
    
    if (shouldUseFormik) {
        try {
            formik = useFormikContext();
        } catch {
            formik = null;
        }
    }

    const [phoneValue, setPhoneValue] = useState<string | undefined>(undefined);

    // ✅ Reset phone input when formik resets its value
    useEffect(() => {
        if (isPhone && shouldUseFormik && formik?.values?.[name] === "") {
            setPhoneValue(undefined);
        }
    }, [formik?.values?.[name], isPhone, name, shouldUseFormik]);

    const handlePhoneChange = (val: string | undefined) => {
        setPhoneValue(val);
        if (shouldUseFormik && formik) {
            formik.setFieldValue(name, val);
        }

        if (onPhoneChange && val) {
            const parsed = parsePhoneNumber(val);
            onPhoneChange({
                countryCode: parsed?.countryCallingCode
                    ? `+${parsed.countryCallingCode}`
                    : "",
                phoneNumber: parsed?.nationalNumber ?? "",
            });
        }
    };

    const renderField = (fieldProps?: FieldProps["field"]) => {
        const commonProps = {
            name,
            value: value ?? fieldProps?.value ?? "",
            onChange: onChange ?? fieldProps?.onChange,
            disabled,
            readOnly,
        };

        if (isPhone) {
            return (
                <div
                    className={clsx(
                        "w-full h-full flex items-center rounded-full overflow-hidden bg-white font-[500]",
                        { "opacity-60 cursor-not-allowed": disabled }
                    )}
                >
                    <PhoneInput
                        {...commonProps}
                        international
                        defaultCountry={defaultCountry as any}
                        value={phoneValue ?? fieldProps?.value}
                        onChange={handlePhoneChange}
                        disabled={disabled}
                        className={clsx(
                            "phone-input w-full h-full outline-0 ps-4 text-base bg-transparent",
                            // { rtl: isArabic },
                            { "!ps-0 pe-4": isArabic }
                        )}
                    />
                </div>
            );
        }

        if (as === "select") {
            return (
                <select
                    {...commonProps}
                    dir={isArabic ? "rtl" : "ltr"}
                    className={clsx(
                        "w-full h-full outline-0 py-2 appearance-none cursor-pointer bg-transparent",
                        {
                            "pe-10 ps-4": !isArabic,
                            "ps-10 pe-4": isArabic,
                            capitalize: !isArabic,
                        }
                    )}
                >
                    {options.map((opt, i) => (
                        <option key={i} value={opt.value}>
                            {opt.label}
                        </option>
                    ))}
                </select>
            );
        }

        if (as === "textarea") {
            return (
                <textarea
                    {...commonProps}
                    placeholder={placeholder}
                    dir={isArabic ? "rtl" : "ltr"}
                    className={clsx("w-full h-full outline-0 ps-4 py-2 resize-none", {
                        capitalize: !isArabic,
                    })}
                />
            );
        }

        return (
            <input
                {...commonProps}
                type={type}
                placeholder={placeholder}
                dir={isArabic ? "rtl" : "ltr"}
                className={clsx("w-full h-full outline-0 ps-4 py-2", {
                    capitalize: !isArabic,
                })}
            />
        );
    };

    return (
        <div className="w-full flex flex-col gap-1 relative">
            <div
                className={clsx(
                    "general-input relative border border-black/10 w-full h-12 rounded-full overflow-hidden ",
                    {
                        "opacity-60 cursor-not-allowed": disabled,
                        "!h-40 !rounded-3xl": as === "textarea",
                    },
                    customClass
                )}
            >
                {isPhone ? (
                    <Field name={name}>{({ field }: FieldProps) => renderField(field)}</Field>
                ) : value !== undefined && onChange ? (
                    renderField()
                ) : (
                    <Field name={name}>{({ field }: FieldProps) => renderField(field)}</Field>
                )}

                {as === "select" && (
                    <div
                        className={clsx(
                            "absolute inset-y-0 flex items-center pointer-events-none transition-transform duration-300",
                            isArabic ? "left-4 justify-start" : "right-4 justify-end"
                        )}
                        style={{ color: disabled ? "#ccc" : indicatorColor }}
                    >
                        {indicatorIcon}
                    </div>
                )}
            </div>

            {shouldUseFormik && formik?.touched?.[name] && formik?.errors?.[name] ? (
                <p
                    className={clsx(
                        "text-red-500 text-sm font-[500] px-4 mt-0.5 absolute -bottom-6 left-1",
                        { "left-auto right-1": lang === "ar" }
                    )}
                >
                    {formik.errors[name] as string}
                </p>
            ) : null}
        </div>
    );
};

export default GeneralInput;
